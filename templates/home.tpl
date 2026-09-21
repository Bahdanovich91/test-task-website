<<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test task</title>
</head>
<body>
    <h1>Test</h1>

    {foreach $categories as $item}
        <section>
            <h2>{$item['category']->name}</h2>
            <p>{$item['category']->description}</p>

            {if $item['posts']}
                <div>
                    {foreach $item['posts'] as $post}
                        <article>
                            <h3>{$post.title}</h3>
                            <p>{$post.description}</p>
                            <span>Views: {$post.views_count}</span>
                        </article>
                    {/foreach}
                </div>
            {else}
                <p></p>
            {/if}
        </section>
    {/foreach}
</body>
</html>