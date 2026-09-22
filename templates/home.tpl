{extends file="layout.tpl"}

{block name="content"}

    <h1>Blog</h1>

    <p>
        <a href="/posts">
            All articles
        </a>
    </p>

    {foreach $categories as $item}
        <section>
            <h2>
                {$item['category']->name}
            </h2>

            <p>
                {$item['category']->description}
            </p>

            {if $item['posts']}
                {foreach $item['posts'] as $post}
                    <article>
                        <h3>
                            <a href="/post/{$post.id}">
                                {$post.title}
                            </a>
                        </h3>

                        <p>
                            {$post.description}
                        </p>

                        <span>
                        Views: {$post.views_count}
                    </span>
                    </article>
                {/foreach}
            {else}
                <p>No articles yet.</p>
            {/if}

            <p>
                <a href="/category/{$item['category']->id}">
                    All articles in this category
                </a>
            </p>
        </section>
    {/foreach}

{/block}
