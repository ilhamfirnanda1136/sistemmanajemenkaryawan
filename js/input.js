function capitalize_Words(str) {
    return str.replace(/\w\S*/g, function (txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
}

function loading() {
    $('#loader').show();
    $('.div-loading').addClass('background-load');
}

function matikanLoading() {
    $('#loader').hide();
    $('.div-loading').removeClass('background-load');
}

function hapusvalidasi(key) {
    let pesan = $('#' + key).parent();
    let text = $('.' + key);
    pesan.removeClass('has-danger');
    text.text(null);
}

function isEmpty(obj) {
  return Object.keys(obj).length === 0;
}




function wordWrap(str, maxWidth) {
    var newLineStr = "<br>"; done = false; res = '';
    while (str.length > maxWidth) {                 
        found = false;
        // Inserts new line at first whitespace of the line
        for (i = maxWidth - 1; i >= 0; i--) {
            if (testWhite(str.charAt(i))) {
                res = res + [str.slice(0, i), newLineStr].join('');
                str = str.slice(i + 1);
                found = true;
                break;
            }
        }
        // Inserts new line at maxWidth position, the word is too long to wrap
        if (!found) {
            res += [str.slice(0, maxWidth), newLineStr].join('');
            str = str.slice(maxWidth);
        }

    }
    return res + str;
}

function testWhite(x) {
    var white = new RegExp(/^\s$/);
    return white.test(x.charAt(0));
};

function getDaysInMonth() {
    let d = new Date();
    let ym = d.getFullYear() * 12 + d.getMonth() + 1;
    let y = Math.floor(ym / 12);
    let m = ym % 12;
    d = new Date(`${y}/${m + 1}/1`);
    d = new Date(d.getTime() - 1);
    const days = d.getDate();
    const array = [];
    for (let i = 1; i <= days; i++) {
        array.push(i);
    }
    return array;
}


