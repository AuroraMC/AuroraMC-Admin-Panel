function addWord(form, word, type, textbox) {
    if (type === 'phrase') {
        if (!word.includes(" ")) {
            alert("A phrase should include a space. This should be put in the core words list instead.")
            return false;
        }
    } else if (type !== 'replacement') {
        if (word.includes(" ")) {
            alert("Words cannot include spaces. This should go in the banned phrases instead.")
            return false;
        }
    }
    if (word === "") {
        return;
    }
    $.ajax({
        url:'/filter/utils/functions.php',
        type: 'post',
        data: "add" + type + "=" + encodeURIComponent(word),
        success: function(result) {
            textbox.value = "";
        }
    });
    return true;
}

function removeWord(word, type) {
    //AJAX remove the user from the blacklist
    $.ajax({
        url:'/filter/utils/functions.php',
        type: 'post',
        data: "remove" + type + "=" + word,
        success: function(result) {
            document.getElementById(word).remove();
        }
    });
}

$(document).ready(function() {
    $('#core').keydown(function(event){
        if(event.keyCode === 13) {
            event.preventDefault();
            return addWord(document.getElementById("usersearch"), document.getElementById("usersearch").core.value, "core", document.getElementById("usersearch").core);
        }
    });
});

$(document).ready(function() {
    $('#whitelist').keydown(function(event){
        if(event.keyCode === 13) {
            event.preventDefault();
            return addWord(document.getElementById("usersearch"), document.getElementById("usersearch").whitelist.value, "whitelist", document.getElementById("usersearch").whitelist);
        }
    });
});

$(document).ready(function() {
    $('#blacklist').keydown(function(event){
        if(event.keyCode === 13) {
            event.preventDefault();
            return addWord(document.getElementById("usersearch"), document.getElementById("usersearch").blacklist.value, "blacklist", document.getElementById("usersearch").blacklist);
        }
    });
});

$(document).ready(function() {
    $('#phrase').keydown(function(event){
        if(event.keyCode === 13) {
            event.preventDefault();
            return addWord(document.getElementById("usersearch"), document.getElementById("usersearch").phrase.value, "phrase", document.getElementById("usersearch").phrase);
        }
    });
});

$(document).ready(function() {
    $('#replacement').keydown(function(event){
        if(event.keyCode === 13) {
            event.preventDefault();
            return addWord(document.getElementById("usersearch"), document.getElementById("usersearch").replacement.value, "replacement", document.getElementById("usersearch").replacement);
        }
    });
});