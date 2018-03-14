function print(){
    "use strict"
    var tasks = [];
    var tasklist_node = document.getElementById("tasklist");
    var count = tasklist_node.childElementCount-1;

    for(var i = 0; i <= count; i++){
        var option_tag = tasklist_node.children[i];
        var id = parseInt(option_tag.getAttribute("id"));
        var prio = parseInt(option_tag.getAttribute("data-prio"));
        var text = String(option_tag.firstChild.nodeValue);
        var due_end = text.search(" ");   // erstes Leerzeichen suchen (zählt ab 0)
        var due = text.substring(0, due_end);   // Datum auslesen (zählt ab 0)
        var desc_begin = text.indexOf(" ", due_end+1);   // Beginn Beschreibung
        var desc_end = text.indexOf("(", desc_begin+1);   // Ende Beschreibung
        var desc = text.substring(desc_begin+1, desc_end-1);   // Beschreibung auslesen

        tasks.push({id: id, prio: prio, due: due, desc: desc});
    }

    for(var i = 0; i < tasks.length; i++){
        var id = String(tasks[i].id);
        var prio = String(tasks[i].prio);
        var due = String(tasks[i].due);
        var desc = String(tasks[i].desc);
        var result = "ID: " + id + " Prio: " + prio + " Due: " + due + " Desc: " + desc;
        console.log(result);
    }
}