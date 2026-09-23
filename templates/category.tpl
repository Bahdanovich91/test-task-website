{extends file="layout.tpl"}

{block name="content"}
    <div class="category-page">
        <div class="category-page-header">
            <h1>{$data.category->getName()}</h1>
            {if $data.category->getDescription()}
                <p>{$data.category->getDescription()}</p>
            {/if}
        </div>

        <div class="sort-toolbar">
            <span class="sort-label">Сортировка:</span>
            <div class="sort-links">
                {foreach $data.sortOptions as $option}
                    <a href="/category/{$data.category->getId()}?sort={$option.key}&direction={$option.nextDirection}"
                       class="sort-btn {if $option.isActive}active{/if}">
                        {$option.label}
                        {if $option.arrow}
                            <span class="sort-arrow">{$option.arrow}</span>
                        {/if}
                    </a>
                {/foreach}
            </div>
        </div>

        {if $data.posts}
            <div class="posts-grid">
                {foreach $data.posts as $post}
                    {include file="partials/post_card.tpl" post=$post}
                {/foreach}
            </div>

            {include file="partials/pagination.tpl"
            totalPages=$data.totalPages
            currentPage=$data.currentPage
            sort=$data.sort
            direction=$data.direction}
        {else}
            <p>В данной категории пока нет статей.</p>
        {/if}

        <div style="margin-top: 28px;">
            <a href="/" class="btn btn-outline">&larr; На главную</a>
        </div>
    </div>
{/block}