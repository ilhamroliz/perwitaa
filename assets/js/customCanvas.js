var canvas; var warnaText; var harga = 50000;  var base = 'original'; var emblem = 'original'; hargaA3 = 40000; hargaA5 = 10000;

$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	$('.black').addClass('active');
    canvas = new fabric.Canvas('canvas-depan');
    canvas.setHeight(425);
	canvas.setWidth(450);
	canvas.backgroundColor="black";
    canvas.on('object:moving', function (e) {
        var obj = e.target;
         // if object is too big ignore
        if(obj.currentHeight > obj.canvas.height || obj.currentWidth > obj.canvas.width){
            return;
        }        
        obj.setCoords();        
        // top-left  corner
        if(obj.getBoundingRect().top < 0 || obj.getBoundingRect().left < 0){
            obj.top = Math.max(obj.top, obj.top-obj.getBoundingRect().top);
            obj.left = Math.max(obj.left, obj.left-obj.getBoundingRect().left);
        }
        // bot-right corner
        if(obj.getBoundingRect().top+obj.getBoundingRect().height  > obj.canvas.height || obj.getBoundingRect().left+obj.getBoundingRect().width  > obj.canvas.width){
            obj.top = Math.min(obj.top, obj.canvas.height-obj.getBoundingRect().height+obj.top-obj.getBoundingRect().top);
            obj.left = Math.min(obj.left, obj.canvas.width-obj.getBoundingRect().width+obj.left-obj.getBoundingRect().left);
        }
    });

    canvas.on('object:selected', function (e) {
        activeObject = e.target;
        console.log(Math.floor(activeObject.getWidth())+' - '+Math.floor(activeObject.getHeight()));
        $('.item-holder').removeClass('active');
		$('.align').removeClass('active');
		$('.font').removeClass('active');
        
        if(activeObject.fill != "rgb(0,0,0)"){
        	$('.'+activeObject.fill).addClass('active');
        	$('.'+activeObject.textAlign).addClass('active');
        	$('.'+activeObject.fontFamily.split(' ').join('')).addClass('active');
        	$('.fontFamily').html(activeObject.fontFamily);
        }

	    //console.log(canvas.getActiveObject().type);

	    if(activeObject.isType('i-text')){
	       //canvas.getActiveObject().set({fontWeight: 'bold'});
	       //console.log(canvas.getActiveObject().fontWeight);

	        if(canvas.getActiveObject().fontWeight == 'bold'){
        		$('.bold').addClass('active');
        	}
            else{
        		$('.bold').removeClass('active');
        	}

        	if(canvas.getActiveObject().fontStyle == 'italic'){
        		$('.italic').addClass('active');
        	}
        	else{
        		$('.italic').removeClass('active');
        	}

        	if(canvas.getActiveObject().textDecoration == 'underline'){
        		$('.underline').addClass('active');
        	}
        	else{
        		$('.underline').removeClass('active');
        	}

	    }
	    else if(activeObject.isType('image')){
	      setImageColorItem(activeObject.id);
	    }
	    else if( activeObject.isType('xyz')){
	      //display shape logic
	    }
    });

    canvas.on('selection:cleared', function() {
		$('.bold').removeClass('active');
		$('.italic').removeClass('active');
		$('.underline').removeClass('active');
		$('.item-holder').removeClass('active');
		$('.align').removeClass('active');
		$('.font').removeClass('active');
		$('.imgColorWrap').html('');
	});

    canvas.on('object:scaling', function(){
	    var obj = canvas.getActiveObject();
	    console.log(Math.floor(obj.getWidth())+' - '+Math.floor(obj.getHeight()));
	});

	var bgnd = new fabric.Image.fromURL("assets/images/pictures/custom/item-custom.png", function(oImg){
	    oImg.hasBorders = false;
	    oImg.hasControls = false;
	    oImg.left = 0;
	    oImg.id = 'bg';
	    oImg.selectable = false;
	    // ... Modify other attributes
	    canvas.add(oImg);
	});

	var img = new fabric.Image.fromURL('assets/images/pictures/base-desain/original/original.png', function(data){
		    data.hasBorders = false;
		    data.hasControls = false;
		    data.scale(0.6);
		    data.left = 135;
		    data.top = 65;
		    data.hasControls = false;
		    data.selectable = false;
		    data.id = 'base';
		    data.transparentCorners = false;
		    // ... Modify other attributes
		    canvas.add(data);
		    
		});

	var img = new fabric.Image.fromURL('assets/images/pictures/desain-emblem/original/original.png', function(data){
		    data.hasBorders = false;
		    data.hasControls = false;
		    data.scale(0.5);
		    data.left = 245;
		    data.top = 65;
		    data.hasControls = false;
		    data.selectable = false;
		    data.id = 'baseEmblem';
		    data.transparentCorners = false;
		    // ... Modify other attributes
		    canvas.add(data);
		    
		});
});


function canvasFocusDisplay(canvasObj){
	$('#'+canvasObj).css('display', 'none');
}

function canvasShow(canvasObj){
	$('#'+canvasObj).css('display', 'block');
}

function existId(array, id){
	for(a = 0; a < array.length; a++){
		canvas.setActiveObject(canvas.item(a));
	    if (canvas.getActiveObject().id == id) {
	        return true;
	    }
	}
	return false;
}

function setBase(baseId){

	imgPath = 'assets/images/pictures/base-desain/'+baseId+'/'+baseId+'-white.png';
	
	if(baseId == 'original'){
		imgPath = 'assets/images/pictures/base-desain/original/original.png';
		if(base != "original"){
			harga = harga - hargaA3;
			base = 'original';
		}
	}else{
		if(base == "original"){
			harga = harga + hargaA3;
			base = baseId;
		}
	}

	if(existId(canvas.getObjects(), 'base')){
		//alert(canvas.getActiveObject().id);
		canvas.getActiveObject().getElement().setAttribute("src", imgPath);
		canvas.discardActiveObject();
		canvas.renderAll();
		canvas.calcOffset();
	}

	$('.base').removeClass('active');
	$('.'+baseId).addClass('active');
	$('.harga').text(harga);
}

function setEmblem(emblemId){

	imgPath = 'assets/images/pictures/desain-emblem/'+emblemId+'/'+emblemId+'-white.png';
	
	var classObj = emblemId;

	if(emblemId == 'original'){
		imgPath = 'assets/images/pictures/desain-emblem/original/original.png';
		classObj = 'emblem-'+emblemId;
		if(emblem != "original"){
			harga = harga - hargaA5;
			emblem = 'original';
		}
	}else{
		if(emblem == "original"){
			harga = harga + hargaA5;
			emblem = emblemId;
		}
	}

	if(existId(canvas.getObjects(), 'baseEmblem')){
		//alert(canvas.getActiveObject().id);
		canvas.getActiveObject().getElement().setAttribute("src", imgPath);
		canvas.discardActiveObject();
		canvas.renderAll();
		canvas.calcOffset();
	}

	$('.emblem').removeClass('active');
	$('.'+classObj).addClass('active');
	$('.harga').text(harga);
}

function setBaseOri(){
	if(canvas.getActiveObject(canvas.item('base')) != undefined){
		canvas.getActiveObject(canvas.item('base')).remove();
	}
}

function addText(){
	var text = new fabric.IText('hello world', {
		fontSize:20,
		textAlign: 'left',
		left: 170,
		top: 335,
		fill: 'white',
		fontFamily: 'Times New Roman'
	});

	canvas.add(text);
	$('.textAdd').val('');
}

function addImage (imgId){
	imgPath = 'assets/images/pictures/desain-dada/'+imgId+'/'+imgId+'-white.png';
	var img = new fabric.Image.fromURL(imgPath, function(data){
	    data.hasBorders = true;
	    data.hasControls = false;
	    data.scale(0.6);
	    data.left = 135;
	    data.top = 65;
	    data.hasControls = true;
	    data.id = imgId;
	    data.transparentCorners = false;
	    // ... Modify other attributes
	    canvas.add(data);
	});

	//setImageColorItem(imgId);
}

function deleteObject(){
	if(exist()){
		canvas.getActiveObject().remove();
		$('.bold').removeClass('active');
		$('.italic').removeClass('active');
		$('.underline').removeClass('active');
		$('.imgColorWrap').html('');
	}
	else{
		alert('tidak ada object yang terpilih');
	}
}

function makeBold(){
	if(exist() && canvas.getActiveObject().type == 'i-text'){
		//alert(canvas.getActiveObject().type);
		if(canvas.getActiveObject().fontWeight == 'bold'){
    		canvas.getActiveObject().set({fontWeight: 'normal'});
    		$('.bold').removeClass('active');
    	}
    	else{
    		canvas.getActiveObject().set({fontWeight: 'bold'});
    		$('.bold').addClass('active');
    	}
    	canvas.renderAll();
	}
	else{
		alert('tidak ada object text yang terpilih');
	}
	
}

function makeItalic(){
	if(exist() && canvas.getActiveObject().type == 'i-text'){
		if(canvas.getActiveObject().fontStyle == 'italic'){
    		canvas.getActiveObject().set({fontStyle: 'normal'});
    		$('.italic').removeClass('active');
    	}
    	else{
    		canvas.getActiveObject().set({fontStyle: 'italic'});
    		$('.italic').addClass('active');
    	}
    	canvas.renderAll();
	}
	else{
		alert('tidak ada object text yang terpilih');
	}

	
}

function makeUnderline(){
	if(exist() && canvas.getActiveObject().type == 'i-text'){
		if(canvas.getActiveObject().textDecoration == 'underline'){
    		canvas.getActiveObject().set({textDecoration: 'normal'});
    		$('.underline').removeClass('active');
    	}
    	else{
    		canvas.getActiveObject().set({textDecoration: 'underline'});
    		$('.underline').addClass('active');
    	}
    	canvas.renderAll();
	}
	else{
		alert('tidak ada object text yang terpilih');
	}
}

function setColor(hexa){
	if(exist() && canvas.getActiveObject().type == 'i-text'){
		canvas.getActiveObject().set({fill: hexa});
		$('.item-holder').removeClass('active');
		$('.'+hexa).addClass('active');
		canvas.renderAll();
    }
	else{
		alert('tidak ada object text yang terpilih');
	}

}

function setAlign(alignment){
	if(exist() && canvas.getActiveObject().type == 'i-text'){
		canvas.getActiveObject().set({textAlign: alignment});
		$('.align').removeClass('active');
		$('.'+alignment).addClass('active');
		canvas.renderAll();
    }
	else{
		alert('tidak ada object text yang terpilih');
	}

}

function setFont(font){
	if(exist() && canvas.getActiveObject().type == 'i-text'){
		canvas.getActiveObject().set({fontFamily: font});
		$('.fontFamily').html(font);
		$('.font').removeClass('active');
		$('.'+canvas.getActiveObject().fontFamily.split(' ').join('')).addClass('active');
		canvas.renderAll();
    }
	else{
		alert('tidak ada object text yang terpilih');
	}

}

function setClothesColor(hexa){
	$('.color-clothes').removeClass('active');
	canvas.backgroundColor = hexa;
	canvas.renderAll();
	setTimeout(function(){
		$('.clothesRight').css('background-color', hexa);
	}, 1000);
	$('.'+hexa).addClass('active');
}

function setImageColor(imgPath){
	if(exist() && canvas.getActiveObject().type == 'image'){
		canvas.getActiveObject().getElement().setAttribute("src", imgPath);
		canvas.renderAll();
		canvas.calcOffset();
	}
	else{
		alert('tidak ada object gambar terpilih');
	}
}

function exist(){
	if(canvas.getActiveObject() == undefined){
		return false;
	}
	else
		return true;
}


function setImageColorItem(imgId){
	//alert(imgId);
	var htmlContent = "";
	htmlContent = htmlContent+'<div class="col-md-3 gambarList" onclick="setImageColor(\'assets/images/pictures/desain-dada/'+imgId+'/'+imgId+'-black.png\')">'+
									'<div class="col-md-12 no-padding">'+
										'<img src="assets/images/pictures/desain-dada/'+imgId+'/'+imgId+'-black.png" height="50px">'+
									'</div>'+
									'<div class="col-md-12"><small>black</small></div>'+
								'</div>';

	htmlContent = htmlContent+'<div class="col-md-3 gambarList" onclick="setImageColor(\'assets/images/pictures/desain-dada/'+imgId+'/'+imgId+'-white.png\')">'+
									'<div class="col-md-12 no-padding">'+
										'<img src="assets/images/pictures/desain-dada/'+imgId+'/'+imgId+'-white.png" height="50px">'+
									'</div>'+
									'<div class="col-md-12"><small>white</small></div>'+
								'</div>';
	

	$('.imgColorWrap').html(htmlContent);
}

function setSize(size){
	$('.size').removeClass('active');
	$('.'+size).addClass('active');
}

function toPng(){
	var png = canvas.toDataURL('png');
	$('.item1').attr('src', png);
}