{extends file="layout.tpl"}

{block name="content"}
    <article>
        <h1>{$data['post'].title}</h1>

        {if $data['post'].image}
            <img src="{$data['post'].image}" alt="{$data['post'].title}">
        {/if}

        <p>{$data['post'].description}</p>

        <p>
            Published: {$data['post'].created_at}
        </p>

        <div>
            {$data['post'].text}
        </div>

        <p>
            Views: {$data['post'].views_count}
        </p>
    </article>
    <section>
        <h2>Similar articles</h2>

        {if $data['similarPosts']}
            {foreach $data['similarPosts'] as $post}
                <article>
                    <h3>
                        <a href="/post/{$post.id}">
                            {$post.title}
                        </a>
                    </h3>

                    <p>{$post.description}</p>

                    <span>
                        Published: {$post.created_at}
                    </span>

                    <span>Views: {$post.views_count}</span>
                </article>
            {/foreach}
        {else}
            <p>No similar articles.</p>
        {/if}
    </section>
    <p>
        <a href="/">All categories</a>
    </p>
{/block}
