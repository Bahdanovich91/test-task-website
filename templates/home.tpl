{extends file="layout.tpl"}

{block name="content"}

    <h1>Blog</h1>

    {foreach $categories as $item}
        <section>
            <h2>{$item['category']->name}</h2>
            <p>{$item['category']->description}</p>

            {if $item['posts']}
                {foreach $item['posts'] as $post}
                    <article>
                        <h3>{$post.title}</h3>
                        <p>{$post.description}</p>
                        <span>Views: {$post.views_count}</span>
                    </article>
                {/foreach}
            {else}
                <p></p>
            {/if}
        </section>
    {/foreach}

{/block}
