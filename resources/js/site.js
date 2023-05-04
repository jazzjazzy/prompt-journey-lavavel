$(document).ready(function () {

    var emailLink = generateMailtoLink('aithought','proton.me');
    $('#email').append(emailLink);

    function generateMailtoLink(user, domain, subject= null, body = null) {
        // Generate the mailto link
        let email = user +'@'+ domain;
        let mailto = 'mailto:' + email;
        if (subject) {
            mailto += '?subject=' + encodeURIComponent(subject);
        }
        if (body) {
            mailto += '&body=' + encodeURIComponent(body);
        }
        var link = $('<a>', {
            href: mailto,
            text: email
        });

        return link;
    }

});
