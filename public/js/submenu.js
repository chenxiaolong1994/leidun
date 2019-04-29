/**
 * 菜单展开
 */

(function(){
    var menuListDom = document.querySelectorAll('#submenu li');
    for (var i=0; i < menuListDom.length; i++) {
        menuListDom[i].addEventListener('mouseenter',handleLiEnter);
        menuListDom[i].addEventListener('mouseleave',handleLiLeave);
    }

    // 光标进入元素
    function handleLiEnter(event){
        var num = event.currentTarget && event.currentTarget.getAttribute('data-num');
        var style = 'display: block;z-index:1000';
        var content = document.querySelector("#submenu .content[data-num='"+num+"']");// 当前菜单具体页
        content && content.setAttribute('style',style);
    }

    // 光标离开元素
    function handleLiLeave(event){
        var num = event.currentTarget && event.currentTarget.getAttribute('data-num');

        var style= 'display: none;z-index:0';
        var style1= 'display: block;z-index:1000';
        var content = document.querySelector("#submenu .content[data-num='"+num+"']");// 当前菜单具体页

        content && content.setAttribute('style',style);

        // 离开li进入具体详情页
        content && content.addEventListener('mouseenter',function(event){
            content && content.setAttribute('style',style1);
        });
        content && content.addEventListener('mouseleave',function(event){
            content && content.setAttribute('style',style);
        });
    }

})();