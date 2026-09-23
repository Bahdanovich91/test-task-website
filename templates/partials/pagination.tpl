{if $totalPages > 1}
    <nav class="pagination" aria-label="Пагинация">
        {if $currentPage > 1}
            <a class="pagination-link" href="?sort={$sort}&direction={$direction}&page={$currentPage - 1}">
                &larr; Назад
            </a>
        {/if}

        <span class="pagination-info">
            Страница {$currentPage} из {$totalPages}
        </span>

        {if $currentPage < $totalPages}
            <a class="pagination-link" href="?sort={$sort}&direction={$direction}&page={$currentPage + 1}">
                Вперед &rarr;
            </a>
        {/if}
    </nav>
{/if}
