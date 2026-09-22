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
                <a href="/category/{$data.category->getId()}?sort=date&direction=DESC"
                   class="sort-btn {if $data.sort == 'date'}active{/if}">
                    По дате
                </a>
                <a href="/category/{$data.category->getId()}?sort=views&direction=DESC"
                   class="sort-btn {if $data.sort == 'views'}active{/if}">
                    По просмотрам
                </a>
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
