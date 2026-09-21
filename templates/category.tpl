{extends file="layout.tpl"}

{block name="content"}

    <h1>{$data['category']->name}</h1>

    <p>{$data['category']->description}</p>

    <p>
        Sort:
        <a href="/category/{$data['category']->id}?sort=date&direction=DESC">
            By date
        </a>

        <a href="/category/{$data['category']->id}?sort=views&direction=DESC">
            By views
        </a>
    </p>

    {if $data['posts']}
        {foreach $data['posts'] as $post}
            <article>
                <h2>{$post.title}</h2>
                <p>{$post.description}</p>
                <span>Views: {$post.views_count}</span>
            </article>
        {/foreach}
    {else}
        <p>No articles yet.</p>
    {/if}

    {if $data['totalPages'] > 1}
        <nav>
            {if $data['currentPage'] > 1}
                <a href="/category/{$data['category']->id}?sort={$data['sort']}&direction={$data['direction']}&page={$data['currentPage'] - 1}">
                    Previous
                </a>
            {/if}

            <span>
            Page {$data['currentPage']} of {$data['totalPages']}
        </span>

            {if $data['currentPage'] < $data['totalPages']}
                <a href="/category/{$data['category']->id}?sort={$data['sort']}&direction={$data['direction']}&page={$data['currentPage'] + 1}">
                    Next
                </a>
            {/if}
        </nav>
    {/if}

    <p>
        <a href="/">All categories</a>
    </p>

{/block}
