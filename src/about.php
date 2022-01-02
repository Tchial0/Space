<?php
//---------------- Space Library ------------
namespace Space;
include_once("lib/spacelibrary.php");
//-------------------------------------------
?>

<!doctype html>
<html lang="pt-PT">
    <head >
        <title>SPACE - SOBRE </title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="styles/style.css" />
        <meta name="viewport" content="width=device-width" />
    </head>

    <body>

        <!-- Header -->    
        <?php include("lib/embeds/header.php"); ?>
        <!-- Header -->

        <section>
        <h2 class="centered">Sobre o Space</h2>
            <nav style="border-radius:5px;margin:auto;width:90%;text-align:center;padding:10px;background:var(--spacefieldsetbackground)">
                <a class="link-form" href="#space">Space</a> | 
                <a class="link-form" href="#star">Estrela</a> | 
                 <a class="link-form" href="#constellation">Constelação</a> |
                  <a class="link-form" href="#standards">Critérios</a> |
                 <a class="link-form" href="#author">Autor</a> 
            </nav>
           
        </section>

        <main style="padding: 10px;">
            <p id="space" class="container-aboutp">
                <a class="link-form"><strong>#Space</strong></a> é um chat online onde cada usuário pode ter uma estrela. Uma conta no Space significa uma estrela. 
                Esta pequena rede social foi projectada para ser o mais símples possível de se utilizar.<br/><br/>
                É totalmente livre. Para ter uma conta(estrela) no Space não é preciso nenhum dado real. Apenas é necessário um nome que nenhuma estrela registrada utiliza.
            </p>
            <p id="star" class="container-aboutp">
               <a class="link-form"><strong>#Estrela</strong></a> é o conceito principal do Space. Para fazer parte do Space você tem que ter pelo menos uma estrela. 
               Não é recomendado, mas um usuário pode criar quantas estrelas quiser. Uma estrela pode ou não fazer parte de uma constelação, 
               mesmo apesar de que no registro de uma estrela é pedido para escolher uma constelação permanente.
               <br/><br/>
               Uma estrela pode entrar e sair de uma constelação quando quiser. O Space foi desenvolvido com o propósito de dar as estrelas 
               liberdade além do aprovável.
                <br/><br/>
                Para criar uma estrela você não tem que fornecer algum dado relacionado à ti na vida real. Apenas as informações da estrela é requerido.
            </p>
            <p id ="constellation" class="container-aboutp">
               No Space existem <a class="link-form"><strong>#Constelações</strong></a>. Constelações são agrupamentos de estrela referenciadas com um nome.
               Por padrão foram criadas 3 constelações no Space. Essas 3 constelações denominadas "Constelações Permanentes".
               <br /><br/>Tal como o nome sugere, estas 3 constelações nunca serão eliminadas nem passadas como propriedade de alguma estrela.
               Para a criação de uma nova estrela, é pedido ao proprietário desta para selecionar umas das 3 constelação permanentes.
            </p>
            <p id ="standards" class="container-aboutp">
               No Space, o nome de uma estrela não pode conter espaços nem caracteres com acentos, porque assim foi decidido pelo criador
               por motivos de simplicidade. Deveras o nome de uma estrela tem um limite de 15 caracteres.<br/><br/>
               A palavra-passe de uma estrela também não pode conter espaços nem caracteres com acentos. A palavra-passe tem no máximo 10
               caracteres.
            </p>
            <address id ="author" class="centered container-aboutp" style="margin-bottom: 16px;">
                Desenvolvido por <a href="mailto:tchialo.crocodile@gmail.com" class="link-star">Chialo Adolfo Armando</a>
            </address>
        </main>    

        <!-- Footer -->
        <footer>
            <?php if(!Star::OnSpace()) include("lib/embeds/navigation_bottom.php"); ?>
            <?php include("lib/embeds/copyright.php"); ?>
        </footer>
        <!-- Footer -->
    </body>
</html>