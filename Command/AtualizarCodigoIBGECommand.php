<?php


namespace BFOS\BrasilBundle\Command;

use BFOS\BrasilBundle\Entity\Cidade;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Loja\ProdutoBundle\Entity\ProdutoManager;
use Loja\ProdutoBundle\Entity\CategoriaProduto;

class AtualizarCodigoIBGECommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('bfos:brasil:atualizar-codigo-ibge')
            ->setDescription('Atualiza a tabela já existende de cidades com o código do munício do IBGE.')
        ->setHelp("Example: php app/console bfos:brasil:atualizar-codigo-ibge")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         */
        $em = $this->getContainer()->get('doctrine')->getEntityManager();

        /**
         * @var EntityRepository $rcidade
         */
        $rcidade = $em->getRepository('BFOSBrasilBundle:Cidade');

        $output->writeln("Iniciando importação...");

        $filepath = __DIR__ . "/../DataFixtures/municipios_ibge.csv";
        $file_handle = fopen($filepath, "r");
        $lineNumber = 1;
        $quantCidades = 0;
        $quantCidadesAtualizadas = 0;
        while (!feof($file_handle)) {
            $line = trim(fgets($file_handle));
            if ($lineNumber > 1 && strlen($line)>0) {

                try {
                    $columns = explode(',', $line);
                    if (count($columns) != 3) {
                        throw new \InvalidArgumentException("Linha " . $lineNumber . " contém conteúdo inválido: " . $line);
                    }
                    array_walk($columns, 'trim');
                    $uf = $columns[0];
                    $codigo = $columns[1];
                    $nomeCidade = $columns[2];
//                    $output->write('Procurando...: ' . $uf . ' - ' . $nomeCidade);

                    /**
                     * @var Cidade $cidade
                     */
                    $cidade = $rcidade->findOneBy(array('uf' => $uf, 'nome' => $nomeCidade));
                    if ($cidade) {
                        $cidade->setCodigoIbge($codigo);
                        $em->persist($cidade);
                        $quantCidadesAtualizadas++;
                    } else {
                        $output->writeln("Não encontrou: " . $uf . ' - ' . $nomeCidade);
                    }
                    $quantCidades++;
                } catch (\InvalidArgumentException $iae) {
                    throw $iae;
                }
            }
            $lineNumber++;
        }
        fclose($file_handle);
        $output->writeln("Salvando os códigos de município...");
        $em->flush();
        $output->writeln("Pronto!");
        $output->writeln("Cidades no arquivo de municípios             : " . $quantCidades);
        $output->writeln("Cidades atualizadas com o código de município: " . $quantCidadesAtualizadas);

    }

}