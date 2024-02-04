/*
 * Copyright (c) 2021-2024 Ethan P-B. All Rights Reserved.
 */

function addWord(form, word, type, textbox) {
    if (type === 'phrases') {
        if (!word.includes(" ")) {
            alert("A phrase should include a space. This should be put in the core words list instead.")
            return false;
        }
    } else if (type !== 'replacements') {
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

function updateRules() {
    $.ajax({
        url:"/filter/utils/update.php", //the page containing php script
        type: "post", //request type,
        success:function(result){
            alert(result)
        }
    });
}

function onLoad() {
    $.ajax({
        url:"/filter/utils/total.php", //the page containing php script
        type: "get", //request type,
        success:function(result) {
            let totals = JSON.parse(result);
            document.getElementById("core").innerHTML= totals["CORE"];
            document.getElementById("blacklist").innerHTML= totals["BLACKLIST"];
            document.getElementById("whitelist").innerHTML= totals["WHITELIST"];
            document.getElementById("phrases").innerHTML= totals["PHRASES"];
            document.getElementById("replacements").innerHTML= totals["REPLACEMENTS"];


            document.getElementById("content").style.display = null;
            document.getElementById("ring").style.display = "none";
        }
    });
}

function onLoadWords(type) {
    $.ajax({
        url:"/filter/utils/get-words.php", //the page containing php script
        type: "get", //request type,
        data: "type=" + encodeURIComponent(type),
        success:function(result) {
            let totals = JSON.parse(result);
            let table = document.getElementById("table-values");
            totals.forEach(function (word) {
                let row = document.createElement("tr");
                table.appendChild(row)
                row.id = word;
                row.innerHTML = "" +
                    "<td>" + word + "</td>" +
                    "<td><button type=\"button\" class=\"btn btn-danger\" onclick=\"removeWord('" + encodeURIComponent(word) + "', '" + type + "')\"><i class=\"fas fa-trash-alt\"></i> Remove</button></td>";
            })

            document.getElementById("content").style.display = null;
            $('#dtHistory').DataTable({
                "pagingType": "full_numbers", // "simple" option for 'Previous' and 'Next' buttons only
                "autoWidth": true,
                "scrollY": "498px",
                "scrollCollapse": true,
                "ordering": false
            });
            $('.dataTables_length').addClass('bs-select');

            document.getElementById("ring").style.display = "none";
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