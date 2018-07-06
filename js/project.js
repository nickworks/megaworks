function doAjax(url,success){
    var req=new XMLHttpRequest();
    req.addEventListener("load",success);
    req.open("GET",url);
    req.send();
}

(function(){
    var bttnLike=document.getElementById("bttnLike");
    var bttnFave=document.getElementById("bttnFave");
    
    bttnLike.addEventListener("mousedown", function(){
        doAjax("/api/project_likes.php?id="+projectID,function(e){
            try{
                var res=JSON.parse(e.target.responseText);
                if(res.error){
                    console.log(res.error);
                } else {
                    bttnLike.getElementsByClassName("count")[0].innerHTML=res.likes;
                    res.userLikes ? bttnLike.classList.add("active") : bttnLike.classList.remove("active");
                }
            } catch{}
        });
    });
                
    bttnFave.addEventListener("mousedown", function(){
        doAjax("/api/project_faves.php?id="+projectID,function(e){
            try{
                var res=JSON.parse(e.target.responseText);
                if(res.error){
                    console.log(res.error);
                } else {
                    bttnFave.getElementsByClassName("count")[0].innerHTML=res.faves;
                    res.userFaves ? bttnFave.classList.add("active") : bttnFave.classList.remove("active");
                }
            } catch{}
        });
    });
    
})();