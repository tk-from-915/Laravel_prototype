<script setup lang="ts">
const showCommentForm = ref(true)
const comment = reactive({ name: '', body: '' })

const submitComment = () => {
  // TODO: GraphQL Mutation でコメントを送信する
  comment.name = ''
  comment.body = ''
}
</script>

<template>
  <div id="backgroud">
    <div id="post_archive">
      <!-- TODO: GraphQL から商品詳細を取得して動的に表示する -->
      <h5 id="news_blog_title">ハロウィンに使われる植物とは？</h5>
      <img src="/images/taniku005.jpeg" class="post_image">
      <div class="post_content">
        ここに記事が入りますここに記事が入りますここに記事が入りますここに記事が入ります
        ここに記事が入りますここに記事が入りますここに記事が入りますここに記事が入ります
        ここに記事が入りますここに記事が入りますここに記事が入りますここに記事が入ります
      </div>

      <div id="comment_area">
        <p class="center">みなさんのコメント</p>
        <!-- TODO: GraphQL からコメント一覧を取得して動的に表示する -->
        <div class="comment_group">
          <img src="/images/hukidashi.jpeg" class="hukidashi">
          <div class="commenter">ポッキー</div>
          <div class="comment">この観葉植物、すくすく育って、今では実を収穫するのが楽しみです</div>
        </div>
        <div class="comment_group">
          <img src="/images/hukidashi.jpeg" class="hukidashi">
          <div class="commenter">みきちゃんママ</div>
          <div class="comment">この間収穫した実を娘と一緒に食べました。美味しかったです</div>
        </div>
        <div class="comment_group">
          <img src="/images/hukidashi.jpeg" class="hukidashi">
          <div class="commenter">ズボラ主婦</div>
          <div class="comment">意外と水をあげなくても勝手に育つ</div>
        </div>
        <button class="green_button comment_more">More  →</button>

        <div v-if="showCommentForm" id="comment_edit_area">
          <h5 class="green">Comments</h5>
          <table id="comment_table">
            <tr>
              <td class="left_cell">ハンドルネーム</td>
              <td class="center_cell"></td>
              <td class="right_cell">
                <input v-model="comment.name" type="text" class="comment_form">
              </td>
            </tr>
            <tr>
              <td class="left_cell">コメント</td>
              <td class="center_cell"></td>
              <td class="right_cell">
                <textarea v-model="comment.body" rows="7" cols="40" maxlength="120" class="comment_form"></textarea>
              </td>
            </tr>
          </table>
          <button id="comment_submit" class="green_button" @click="submitComment">コメントする</button>
        </div>
      </div>
    </div>
  </div>
</template>
