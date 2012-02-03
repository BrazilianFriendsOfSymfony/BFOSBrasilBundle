BrasilBundle
============

Este bundle reúne componentes que são úteis no desenvolvimento de aplicativos web
com Symfony 2 no Brasil.

Componentes
===========

Widget que possibilita o uso de cidade em seus formulários. Exibir dois combos ESTADO/CIDADE e o conteúdo de cidade
é carregado por Ajax.

Requisitos
==========

- jQuery

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


