$(function () {

    $(document).on("click", '.comment-delete', function () {
        comment = $(this).parent().data('panel');
        itemId = $('[name=comments]').data('item');
        $.ajax({
            type: 'POST',
            url: '/bitrix/tools/comments.php',
            dataType: 'json',
            data: {action: 'delete', id: comment, item: itemId},
            beforeSend: function (data) {
                $('#comment' + comment).remove();
            },
            success: function (data) {

            }
        });
    });


    $(document).on("click", ".comment-save", function () {

        commentArea = $(this).parent();
        comment = $(this).parent().data('comment');

        text = commentArea.find('.edited-comment').val();
        itemId = $('[name=comments]').data('item');
        $.ajax({
            type: 'POST',
            url: '/bitrix/tools/comments.php',
            dataType: 'json',
            data: {action: 'edit', id: comment, text: text, item: itemId},
            beforeSend: function (data) {

                commentArea.html(text.replace(/([^>])\n/g, '$1<br/>'));
            },
            success: function (data) {

            }
        });
        return false;
    });
    
    
    $(document).on("click", '.comment-edit', function () {

        comment = $(this).parent().data('panel');
        commentArea = $('[data-comment=' + comment + ']');

        if (!commentArea.find('.edited-comment').size()) {
            text = commentArea.text();
            commentArea.html('<textarea class="edited-comment">' + text + '</textarea>\n\
                              <a href="#" class="comment-save">Сохранить</a>');
        }
    });


});
 