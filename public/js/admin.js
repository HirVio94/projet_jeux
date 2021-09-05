$(function(){
    img = $('img')[0];
    imgOriginePath = $('img')[0].src; 
})

function majImgJeux(){
    input = $('input[type=file]')[0];
    console.log(input.files[0]);
    console.log(img);
    img.src = URL.createObjectURL(input.files[0]);
    console.log(URL.createObjectURL(input.files[0]));
}

function resetImg(event){
    img.src = imgOriginePath;
    input = $('input[type=file]')[0];
    input.value = '';
    event.preventDefault();
}