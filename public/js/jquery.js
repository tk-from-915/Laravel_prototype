$(document).ready( function(){
    // ページ読み込み時に実行したい処理

    //管理画面のサイドバーの色
    const dir = location.pathname;
    switch (true) {
        case /users/.test(dir):
            $("#sidebar_li_users").addClass("this_page");
            $("#sidebar_a_users").removeClass("whitelink");
            break;
        case /menus/.test(dir):
            $("#sidebar_li_menus").addClass("this_page");
            $("#sidebar_a_menus").removeClass("whitelink");
            break;
        case /news/.test(dir):
            $("#sidebar_li_news").addClass("this_page");
            $("#sidebar_a_news").removeClass("whitelink");
            break;
        case /blogs/.test(dir):
            $("#sidebar_li_blogs").addClass("this_page");
            $("#sidebar_a_blogs").removeClass("whitelink");
            break;
        case /pages/.test(dir):
            $("#sidebar_li_pages").addClass("this_page");
            $("#sidebar_a_pages").removeClass("whitelink");
            break;
        case /contacts/.test(dir):
            $("#sidebar_li_contacts").addClass("this_page");
            $("#sidebar_a_contacts").removeClass("whitelink");
            break;
        default :
            $("#sidebar_li_home").addClass("this_page");
            $("#sidebar_a_home").removeClass("whitelink");
            break;
    }

    //お問い合わせ詳細画面のタブ初期表示
    $("#tab1").addClass("active");
    $("#panel1").addClass("active");

  });

//管理画面右上ボタン
$("#management_screen_header_dropdown").on('click', function () {
    $(".dropdown_menu,.triangle").toggle();
});

//リスト削除ボタン
$("#delete_item").on('click', function () {
    const delete_ids =[];
    delete_ids.length = 0;
    
    //選択したチェックを配列にまとめる
    $('input:checkbox[name="delete_check"]:checked').each(function() {
        delete_ids.push($(this).val());
    });
    
    //削除処理が完了した数
    var deleted_item = 0;
    var path = location.pathname;

    //選択したチェック数分、delete処理を走らせる
    for ( let i = 0;  i < delete_ids.length;  i++  ) {
        var id = delete_ids[i];

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: path + "/" + id,
            type: "DELETE",

        }).done(function () {
            deleted_item += 1;

        }).fail(function () {
            alert('ひとつ削除に失敗しました。');
            deleted_item += 1;

        }).always(function () {
            if (deleted_item === delete_ids.length) {
                location.reload();
            }
        });
    }
    
});  

//お問い合わせ詳細画面のタブ切り替え
$(function(){
    $(".tab_label").on("click",function(){
        var $this = $(this).index();
        $(".tab_label").removeClass("active");
        $(".tab_panel").removeClass("active");
        $(this).addClass("active");
        $(".tab_panel").eq($this).addClass("active");
    });
});

  