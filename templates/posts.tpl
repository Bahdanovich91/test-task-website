{extends file="layout.tpl"}

{block name="content"}
    <div class="posts-page">
        <div class="category-page-header">
            <h1>Все статьи</h1>
        </div>

        <div class="sort-toolbar">
            <span class="sort-label">Сортировка:</span>
            <div class="sort-links">
                <a href="/posts?sort=date&direction=DESC"
                   class="sort-btn {if $data.sort == 'date'}active{/if}">
                    По дате
                </a>
                <a href="/posts?sort=views&direction=DESC"
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
            <p>Статей пока нет.</p>
        {/if}

        <div style="margin-top: 28px;">
            <a href="/" class="btn btn-outline">&larr; На главную</a>
        </div>
    </div>
{/block}
