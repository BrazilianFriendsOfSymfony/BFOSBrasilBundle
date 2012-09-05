BrasilBundle
============

Este bundle reúne componentes que são úteis no desenvolvimento de aplicativos web
com Symfony 2 no Brasil.

Componentes
===========

* Cidade/UF Form Type
Widget que possibilita o uso de cidade em seus formulários. Exibir dois combos ESTADO/CIDADE e o conteúdo de cidade
é carregado por Ajax.

* CPF/CNPJ Constraint Validator: Valida CPF/CPNJ nos seus objetos de domínio.

* Telefone Constraint Validator: Valida telefone nos seus objetos de domínio.

* DDD Constraint Validator: Valida DDD nos seus objetos de domínio.

Requisitos
==========

- jQuery
- RequireJS

Instalação
==========

1. Adicione o arquivo de formulário do BrasilBundle

    # Twig Configuration
    twig:
        debug:            %kernel.debug%
        strict_variables: %kernel.debug%
        form:
            resources:
                - 'BFOSBrasilBundle:Form:form_div_layout.html.twig'

2. Importe as rotas no routing.yml

    bfos_brasil:
        resource: "@BFOSBrasilBundle/Resources/config/routing.yml"


3. Para utilizar Cidade/UF Form Type, é necessário utilizar o bundle DoctrineFixturesBundle para carregar as
cidades no banco de dados. O comando abaixo fará isso.

    php app/console doctrine:fixtures:load

Documentação
============

Veja a pasta Resources/doc para mais informações.