/**
 * Created by fnolackfote on 17/03/2016.
 */

function refreshComment() {
    $('#form-comment').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var content = form.find("textarea[name='FCC_content']").val();
        var username = form.find("input[name='FCC_username']").val();
        var email = form.find("input[name='FCC_email']").val();
        var fnc_id = form.data('news');
        //if (content === '' || username === '') {
        //    alert('ERREUR');
        //    return false;
        //}
        $.post(
            '/newComment',
            {
                'FCC_content': content,
                'FCC_username': username,
                'FCC_email': email,
                'FCC_fk_FNC': fnc_id
            },
            function (data) {
                for (var i = 0; i < data.comment.length; i++) {
                    $('.comment:first').before(dataComment(data.comment[i]));
                }
                form.find("textarea").val('');
                //$('#list-comment').load(window.location + ' #list-comment');
            },
            'json'
        );

        return false;
    });
}

function dataComment(comment) {
    return $('<fieldset></fieldset>')
        .attr('class','comment').attr('id',comment.fcc_id)
            .append(
        $('<legend></legend>')
            .append('Posté par ',
                $('<b></b>')
                    .text(comment.author),
                ' le ',
                comment.fcc_date
            ),
        $('<p></p>')
            .text(comment.content)
    );
}

function setVisibleOtherComment() {
    $(window).scroll(function(){
        var load = false;
        var offset = $('.comment:last').offset();
        var id = $('.comment:last').attr('id');

        if(offset.top - $(window).height() <= $(window).scrollTop() && load == false) {
            load = true;

            $.get(
                '/showComment-'+id,
                false,
                function(data) {
                    if(data != '') {
                        for (var i = 0; i < data.comment.length; i++) {
                            $('.comment:last').after(dataComment(data.comment[i]));
                        }
                        //$('#list-comment').load('/showComment-'+id);
                    }
                },
                'json'
            );
        }
    });
}