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

/**
 * ブログサムネイル用ファイルアップロードからサムネイル生成処理まで
 * 
 */
$(function(){
    
    //サムネイルアップボタンを押したらフォームをクリック
    $("#upload_thumnail_button").change(function(){
        $("#thumnail").click();
    });

    //post投稿時のサムネイル表示
    $('#thumnail').click(function(e) {
            var file = e.target.files[0]; 
            create_thumnail(file);
    });


    //ドラッグ&ドロップでサムネイル表示
    $("#thumnail_drug_and_drop").on('dragover',function (e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).css("border","#007575 1px dashed");

    }).on('dragleave',function (e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).css("border","none");

    }).on('drop',function (e) {
        e.stopPropagation();
        e.preventDefault();

        var files = e.originalEvent.dataTransfer.files;

        if (files.length > 1){
            alert('アップロードできるファイルは1つだけです。');
        }

        var file = files[0];
        if (file.type =='image/png' |
            file.type =='image/jpeg' | 
            file.type =='image/jpg'|
            file.type =='image/gif'){

            create_thumnail(file);

        }else{
            return alert('アップロードできるファイル形式はjpeg,jpg,png,gifだけです。');
        }
        
    });


    /**
     * サムネイル作成処理
     * @param file
     */
    var create_thumnail =function(file){
        var fileReader = new FileReader();

        fileReader.onload = function() {
            // Data URIを取得
            var dataUri = this.result;
    
            // img要素に表示
            $('#thumnail_img').attr('src', dataUri);
        }
    
        // ファイルをData URIとして読み込む
        fileReader.readAsDataURL(file);
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