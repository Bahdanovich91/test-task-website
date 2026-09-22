<article class="post-card">
    <div class="post-card-image">
        {if $post->getImage()}
            <img src="{$post->getImage()}" alt="{$post->getTitle()}">
        {else}
            <img src="/images/default.svg" alt="{$post->getTitle()}">
        {/if}
    </div>
    <div class="post-card-content">
        <h3 class="post-card-title">
            <a href="/post/{$post->getId()}">{$post->getTitle()}</a>
        </h3>
        <p class="post-card-desc">{$post->getDescription()}</p>
        <div class="post-card-meta">
            <span>{$post->getCreatedAt()|default:''}</span>
            <span>Просмотры: {$post->getViewsCount()}</span>
        </div>
    </div>
</article>
