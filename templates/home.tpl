{extends file="layout.tpl"}

{block name="content"}
    <div class="home-page">
        {foreach $categories as $item}
            <section class="category-block">
                <div class="category-header">
                    <h2 class="category-title">
                        <a href="/category/{$item.category->getId()}">{$item.category->getName()}</a>
                    </h2>
                    {if $item.category->getDescription()}
                        <p class="category-desc">{$item.category->getDescription()}</p>
                    {/if}
                </div>

                {if $item.posts}
                    <div class="posts-grid">
                        {foreach $item.posts as $post}
                            {include file="partials/post_card.tpl" post=$post}
                        {/foreach}
                    </div>
                {else}
                    <p>В этой категории пока нет статей.</p>
                {/if}

                <div class="category-footer">
                    <a href="/category/{$item.category->getId()}" class="btn btn-outline">
                        Все статьи &rarr;
                    </a>
                </div>
            </section>
            {foreachelse}
            <p>Категории не найдены.</p>
        {/foreach}
    </div>
{/block}
