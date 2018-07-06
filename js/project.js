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
                console.log(res);
                if(res.error){
                    console.log(res.error);
                } else {
                    bttnLike.getElementsByClassName("count")[0].innerHTML=res.likes;
                    res.userLikes ? bttnLike.classList.add("active") : bttnLike.classList.remove("active");
                }
            } catch{}
        });
    });
    
})();