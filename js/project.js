function doAjax(url,success){
    var req=new XMLHttpRequest();
    req.addEventListener("load",success);
    req.open("GET",url);
    req.send();
}

(function(){
    var bttnLike=document.getElementById("bttnLike");
    var bttnFave=document.getElementById("bttnFave");
    var mainImage =document.getElementById("mainImage");
    var images = document.getElementsByClassName("thumbnailImg");

    if(bttnLike)bttnLike.addEventListener("mousedown", function(){
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
                
    if(bttnFave)bttnFave.addEventListener("mousedown", function(){
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
                
                
                
    for(var i = 0; i<images.length; i++){
       
        images[i].addEventListener("mousedown", function(e){
            
           mainImage.setAttribute("src", e.target.getAttribute("src"));
        });
        
       
    }
    //reference the big image
    //get reference to every thumbnail image 
    //add a mousedown event to each
    //change the big image SRC attribute to whatever was clicked on
    
})();