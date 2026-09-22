{extends file="layout.tpl"}

{block name="content"}

    <h1>All articles</h1>

    <p>
        <a href="/posts?sort=date&direction=DESC">
            By date
        </a>

        <a href="/posts?sort=views&direction=DESC">
            By views
        </a>
    </p>

    {if $data['posts']}
        {foreach $data['posts'] as $post}
            <article>
                <h2>
                    <a href="/post/{$post.id}">
                        {$post.title}
                    </a>
                </h2>

                <p>
                    {$post.description}
                </p>

                <p>
                    Published: {$post.created_at}
                </p>

                <p>
                    Views: {$post.views_count}
                </p>
            </article>
        {/foreach}
    {else}
        <p>No articles yet.</p>
    {/if}

    {if $data['totalPages'] > 1}
        <nav>
            {if $data['currentPage'] > 1}
                <a href="/posts?sort={$data['sort']}&direction={$data['direction']}&page={$data['currentPage'] - 1}">
                    Previous
                </a>
            {/if}

            <span>
            Page {$data['currentPage']} of {$data['totalPages']}
        </span>

            {if $data['currentPage'] < $data['totalPages']}
                <a href="/posts?sort={$data['sort']}&direction={$data['direction']}&page={$data['currentPage'] + 1}">
                    Next
                </a>
            {/if}
        </nav>
    {/if}

    <p>
        <a href="/">Home</a>
    </p>

{/block}
