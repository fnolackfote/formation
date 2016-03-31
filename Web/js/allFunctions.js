/**
 * Created by fnolackfote on 17/03/2016.
 */

/**
 *
 */
function refreshComment() {
    var locker = false;

    $('#form-comment').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var content = form.find("textarea[name='FCC_content']");
        var username = form.find("input[name='FCC_username']");
        var email = form.find("input[name='FCC_email']");
        var fnc_id = form.data('news');
        var regex = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;

        $.post(
            '/newComment',
            {
                'FCC_content': content.val(),
                'FCC_username': username.val(),
                'FCC_email': email.val(),
                'FCC_fk_FNC': fnc_id
            },
            function (data) {
                $('.errortext').remove();
                //console.log(data);
                //return ;
                if(typeof data.comment != 'undefined') {
                    for (var i = 0; i < data.comment.length; i++) {
                        $('.comment:first').before(dataComment2(data.comment[i], data.link_a[i]));
                        //$('#list-comment').load(window.location + ' .comment');
                    }
                    content.val('');
                }
                else if(typeof data.error_a != 'undefined') {
                    if(typeof username.maxLength != 'undefined') {
                        if (username.val() == '') {
                            username.before(dataError(data.error_a.FCC_username[1]));
                        } else if (username.val().length > username.maxLength) {
                            username.before(dataError(data.error_a.FCC_username[0]));
                        }
                    }

                    if(typeof email.maxLength != 'undefined') {
                        if (email.val() != '' && !regex.test(email.val())) {
                            email.before(dataError(data.error_a.FCC_email[1]));
                        } else if (email.val().length > email.maxLength) {
                            email.before(dataError(data.error_a.FCC_email[0]));
                        }
                    }

                    if(content.val() == ''){
                        content.before(dataError(data.error_a.FCC_content));
                    }
                }
            },
            'json'
        );
        return false;
    });
}


function modif(){
    $('.modif').click( function(e){
        var form = $('#form-comment');
        var fcc_id = $(this).parent().parent().attr('id');
        var fnc_id = form.data('news');
        var fcc_text = $('#'+fcc_id+' p').text();
        if($("textarea").val() == '') {
            $("textarea").val(fcc_text);
        }else {
            alert('votre formulaire contient deja du texte. Veillez le soumettre avant');
        }
        return false;
    });
}

/**
 * Structure des messages d'erreur
 * @param error
 * @returns {XMLList|*|jQuery}
*/
function dataError(error)
{
    return $('<p></p>').attr('class', 'errortext').text(error);
}

/**
 *
 * @param comment
 * @returns {void|jQuery}
 */
function dataComment(comment) {
    return $('<fieldset></fieldset>')
        .attr('class','comment')
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

function dataComment2(comment, link) {
    return $('<fieldset></fieldset>')
        .attr('class','comment')
        .attr('id',comment.fcc_id)
        .append(
            $('<legend></legend>')
                .append('Posté par ',
                    $('<b></b>')
                        .text(comment.author),
                    ' le ',
                    comment.fcc_date
                )
                .append((link.length >= 1)?' - ':'',
                    link[0]
                )
                .append((link.length === 2)?' - ':'',
                    link[1]
                ),
            $('<p></p>')
                .text(comment.content)
        );
}

/**
 *
 */
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
                    //return;
                    if(typeof data.comment !== 'undefined' && id == $('.comment:last').attr('id')) {
                        //console.log(data);
                        console.log(id);
                        for (var i = 0; i < data.comment.length; i++) {
                            $('.comment:last').after(dataComment2(data.comment[i], data.link_a[i]));
                        }
                        load = false;
                        //$('#list-comment').load('/showComment-'+id);
                    }
                    return false;
                },
                'json'
            );
        }
        return false;
    });
}