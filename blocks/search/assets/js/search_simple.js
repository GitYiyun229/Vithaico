function submit_form_search(){itemid=10,url="";var e=$("#keyword_simple").val(),a=$("#link_search_simple").val();if(0==(""!=e?(url+="&keyword="+e,1):0))
    return alert("Bạn phải nhập tham số tìm kiếm"),!1;e=a+"/"+e;
    return window.location.href=e,!1}$(document).ready(function(){$("#keyword_simple").autocomplete({serviceUrl:"/index.php?module=products&view=search&raw=1&task=get_ajax_search",groupBy:"brand",minChars:2,formatResult:function(e,a){a=a.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g,"\\$&");var r=e.data.text.split(" "),t="";for(j=0;j<r.length;j++)t+=0<=a.toLowerCase().indexOf(r[j].toLowerCase())?"<strong>"+r[j]+"</strong> ":r[j]+" ";return' <a href = "'+e.value+'" > <img src = "'+e.data.image+'" /> <label> <span> '+t+' </span> <span class = "price"> '+e.data.price+"</span></label></a>"},onSelect:function(e){$(".control input[name=kwd]").val(e.data.text)}})});
const texts = ['Rẻ mà bền…','iphone 12 promax'];
const input = document.querySelector('#keyword_simple');
const animationWorker = function (input, texts) {
    this.input = input;
    this.defaultPlaceholder = this.input.getAttribute('placeholder');
    this.texts = texts;
    this.curTextNum = 0;
    this.curPlaceholder = '';
    this.blinkCounter = 0;
    this.animationFrameId = 0;
    this.animationActive = false;
    this.input.setAttribute('placeholder',this.curPlaceholder);

    this.switch = (timeout) => {
        this.input.classList.add('imitatefocus');
        setTimeout(
            () => {
                this.input.classList.remove('imitatefocus');
                if (this.curTextNum == 0)
                    this.input.setAttribute('placeholder',this.defaultPlaceholder);
                else
                    this.input.setAttribute('placeholder',this.curPlaceholder);

                setTimeout(
                    () => {
                        this.input.setAttribute('placeholder',this.curPlaceholder);
                        if(this.animationActive)
                            this.animationFrameId = window.requestAnimationFrame(this.animate)},
                    timeout);
            },
            timeout);
    }

    this.animate = () => {
        if(!this.animationActive) return;
        let curPlaceholderFullText = this.texts[this.curTextNum];
        let timeout = 900;
        if (this.curPlaceholder == curPlaceholderFullText+'|' && this.blinkCounter==3) {
            this.blinkCounter = 0;
            this.curTextNum = (this.curTextNum >= this.texts.length-1)? 0 : this.curTextNum+1;
            this.curPlaceholder = '|';
            this.switch(3000);
            return;
        }
        else if (this.curPlaceholder == curPlaceholderFullText+'|' && this.blinkCounter<3) {
            this.curPlaceholder = curPlaceholderFullText;
            this.blinkCounter++;
        }
        else if (this.curPlaceholder == curPlaceholderFullText && this.blinkCounter<3) {
            this.curPlaceholder = this.curPlaceholder+'|';
        }
        else {
            this.curPlaceholder = curPlaceholderFullText
                .split('')
                .slice(0,this.curPlaceholder.length+1)
                .join('') + '|';
            timeout = 150;
        }
        this.input.setAttribute('placeholder',this.curPlaceholder);
        setTimeout(
            () => { if(this.animationActive) this.animationFrameId = window.requestAnimationFrame(this.animate)},
            timeout);
    }

    this.stop = () => {
        this.animationActive = false;
        window.cancelAnimationFrame(this.animationFrameId);
    }

    this.start = () => {
        this.animationActive = true;
        this.animationFrameId = window.requestAnimationFrame(this.animate);
        return this;
    }
}

document.addEventListener("DOMContentLoaded", () => {
    let aw = new animationWorker(input, texts).start();
    input.addEventListener("focus", (e) => aw.stop());
    input.addEventListener("blur", (e) => {
        aw = new animationWorker(input, texts);
        if(e.target.value == '') setTimeout( aw.start, 2000);
    });
});