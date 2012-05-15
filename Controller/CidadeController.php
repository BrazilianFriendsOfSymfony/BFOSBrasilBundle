<?php

namespace BFOS\BrasilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class CidadeController extends Controller
{
    /**
     * @Route("/bfos/brasil/cidades/busca", name="bfos_brasil_cidades_busca")
     * @Template()
     */
    public function buscaCidadesAction()
    {
        $em = $this->get('doctrine')->getEntityManager();
        $rcidades = $em->getRepository('BFOSBrasilBundle:Cidade');

        $uf = $this->container->get('request')->query->get('uf');

        $cidades = $rcidades->findByUf($uf);

        if (empty($cidades)) {
            return new Response('<option value="">Nenhuma cidade encontrada.</option>');
        }

        $html = '';
        foreach($cidades as $cidade)
        {
            $html = $html . sprintf("<option value=\"%d\">%s</option>",$cidade->getId(), $cidade->getNome());
        }

        return new Response($html);
    }
}
