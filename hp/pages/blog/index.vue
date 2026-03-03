<template>
  <div id="backgroud">
    <div id="post_archive">
      <h3 id="news_archive_title">News</h3>
      <!-- TODO: GraphQL から記事一覧を取得して動的に表示する -->
      <NuxtLink to="/blog/1">
        <div class="post_block">
          <div class="post_thumnail"></div>
          <div class="post_title">ここにタイトルが入ります。</div>
          <div class="post_created_at">2020-10-01</div>
          <div class="post_author">Author：〇〇△△△</div>
        </div>
      </NuxtLink>
      <div class="post_block">
        <div class="post_thumnail"></div>
        <div class="post_title">あああああああああああああああああああああああああああああ</div>
        <div class="post_created_at">2020-10-01</div>
        <div class="post_author">Author：〇〇△△△</div>
      </div>
      <div class="post_block">
        <div class="post_thumnail"></div>
        <div class="post_title">ここにタイトルが入ります。</div>
        <div class="post_created_at">2020-10-01</div>
        <div class="post_author">Author：〇〇△△△</div>
      </div>
      <div class="post_block">
        <div class="post_thumnail"></div>
        <div class="post_title">ここにタイトルが入ります。</div>
        <div class="post_created_at">2020-10-01</div>
        <div class="post_author">Author：〇〇△△△</div>
      </div>
      <div class="post_block">
        <div class="post_thumnail"></div>
        <div class="post_title">ここにタイトルが入ります。</div>
        <div class="post_created_at"></div>
        <div class="post_author"></div>
      </div>
    </div>
  </div>
</template>
