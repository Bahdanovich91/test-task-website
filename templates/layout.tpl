<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{block name="title"}{$title|default:'Блог'}{/block}</title>
    <link rel="stylesheet" href="/css/style.css">
    {block name="head"}{/block}
</head>
<body>
{include file="partials/header.tpl"}

<main class="site-main">
    <div class="container">
        {block name="content"}
            {if isset($content)}
                {include file=$content}
            {/if}
        {/block}
    </div>
</main>

{include file="partials/footer.tpl"}
</body>
</html>
