<span class="pagination">    

    <button onclick="setFilter('all')">All</button>
    <button onclick="setFilter('tagged')">Tagged</button>
    <button onclick="setFilter('untagged')">Untagged</button>

<?php if ($page > 1): ?>
    <a href="?page=<?php echo $page - 1; ?>" class="btn">🡰</a>
    <?php endif; ?>
    <span><?php echo $page; ?> of <?php echo $total_pages; ?></span>
<?php if ($page < $total_pages): ?>
    <a href="?page=<?php echo $page + 1; ?>" class="btn">🡲</a>
    <?php endif; ?>
</span>
