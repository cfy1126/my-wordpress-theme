<form action="/" method="get">
    <labe for="search">Search</label>

        <!-- 指定存档内容中搜索 tag_ID: 8 -->
        <input type="hidden" name="cat" value="8">

        <!-- name 等于 "s" 为固定 -->
        <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" required>
        <button type="submit">Search!</button>
</form>