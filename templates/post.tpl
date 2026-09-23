{extends file="layout.tpl"}

{block name="content"}
    <div class="post-page">
        {if $data.post}
            <article class="post-view">
                <div class="post-header">
                    <h1 class="post-title">{$data.post->getTitle()}</h1>
                    <div class="post-meta">
                        <span>Опубликовано: {$data.post->getCreatedAt()}</span>
                        <span>&bull;</span>
                        <span>Просмотры: {$data.post->getViewsCount()}</span>
                        {if $data.categories}
                            <span>&bull;</span>
                            <span class="post-categories">
                Категории:
                {foreach $data.categories as $category}
                    <a href="/category/{$category->getId()}">{$category->getName()}</a>{if !$category@last}, {/if}
                {/foreach}
            </span>
                        {/if}
                    </div>
                </div>

                {if $data.post->getImage()}
                    <img src="{$data.post->getImage()}" alt="{$data.post->getTitle()}" class="post-image">
                {else}
                    <img src="/images/default.svg" alt="{$data.post->getTitle()}" class="post-image">
                {/if}

                <div class="post-lead">
                    {$data.post->getDescription()}
                </div>

                <div class="post-body">
                    {$data.post->getText()}
                </div>

                <div class="post-footer">
                    <a href="/" class="btn btn-outline">&larr; На главную</a>
                </div>
            </article>

            {if $data.similarPosts}
                <section class="similar-posts">
                    <h2>Похожие статьи</h2>
                    <div class="posts-grid">
                        {foreach $data.similarPosts as $post}
                            {include file="partials/post_card.tpl" post=$post}
                        {/foreach}
                    </div>
                </section>
            {/if}
        {else}
            <p>Статья не найдена.</p>
            <div style="margin-top: 20px;">
                <a href="/" class="btn btn-outline">&larr; На главную</a>
            </div>
        {/if}
    </div>
{/block}
