function moveUp(){
    "use strict"
    var tasklist_node = document.getElementById("tasklist");
    var index = tasklist_node.selectedIndex;
    if(index == -1){
        alert("Kein Element ausgewählt");
    }
    else{
        if(index > 0){
            // index vor index-1 einfügen 
            tasklist_node.insertBefore(tasklist_node.children[index], tasklist_node.children[index-1]);   
        }
    }
}

function moveDown(){
    "use strict"
    var tasklist_node = document.getElementById("tasklist");
    var index = tasklist_node.selectedIndex;
    if(index == -1){
        alert("Kein Element ausgewählt");
    }
    else{
        if(index < tasklist_node.childElementCount-1){
            // index+1 vor index einfügen  
            tasklist_node.insertBefore(tasklist_node.children[index+1], tasklist_node.children[index]);   
        }
    }
}