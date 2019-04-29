(function () {

   
    var URL = window.UEDITOR_HOME_URL || getUEBasePath();

    window.UEDITOR_CONFIG = {

        UEDITOR_HOME_URL: URL

        , serverUrl: URL + "php/controller.php"

        , toolbars: [[
            
            'bold', 'italic',   
            
             'fontfamily', 'fontsize', 
            
            'justifyleft', 'justifycenter', 'justifyright',  
            'imagenone', 'imageleft', 'imageright', 'imagecenter', 
            'simpleupload', 'insertimage',   'fullscreen', 
            
            
        ]]
        
		,xssFilterRules: true
		,inputXssFilter: true
		,outputXssFilter: true
		,elementPathEnabled:false
		,wordCount:false
		,whitList: {
			a:      ['target', 'href', 'title'],
			abbr:   ['title'],
			address: [],
			area:   ['shape', 'coords', 'href', 'alt'],
			article: [],
			aside:  [],
			audio:  ['autoplay', 'controls', 'loop', 'preload', 'src'],
			b:      [],
			bdi:    ['dir'],
			bdo:    ['dir'],
			big:    [],
			blockquote: ['cite'],
			br:     [],
			caption: [],
			center: [],
			cite:   [],
			code:   [],
			col:    ['align', 'valign', 'span', 'width'],
			colgroup: ['align', 'valign', 'span', 'width'],
			dd:     [],
			del:    ['datetime'],
			details: ['open'],
			div:    [],
			dl:     [],
			dt:     [],
			em:     [],
			font:   ['color', 'size', 'face'],
			footer: [],
			h1:     [],
			h2:     [],
			h3:     [],
			h4:     [],
			h5:     [],
			h6:     [],
			header: [],
			hr:     [],
			i:      [],
			img:    ['src', 'alt', 'title', 'width', 'height', 'id', '_src', 'loadingclass'],
			ins:    ['datetime'],
			li:     [],
			mark:   [],
			nav:    [],
			ol:     [],
			p:      [],
			pre:    [],
			s:      [],
			section:[],
			small:  [],
			span:   [],
			sub:    [],
			sup:    [],
			strong: [],
			table:  ['width', 'border', 'align', 'valign'],
			tbody:  ['align', 'valign'],
			td:     ['width', 'rowspan', 'colspan', 'align', 'valign'],
			tfoot:  ['align', 'valign'],
			th:     ['width', 'rowspan', 'colspan', 'align', 'valign'],
			thead:  ['align', 'valign'],
			tr:     ['rowspan', 'align', 'valign'],
			tt:     [],
			u:      [],
			ul:     [],
			video:  ['autoplay', 'controls', 'loop', 'preload', 'src', 'height', 'width']
		}
    };

    function getUEBasePath(docUrl, confUrl) {

        return getBasePath(docUrl || self.document.URL || self.location.href, confUrl || getConfigFilePath());

    }

    function getConfigFilePath() {

        var configPath = document.getElementsByTagName('script');

        return configPath[ configPath.length - 1 ].src;

    }

    function getBasePath(docUrl, confUrl) {

        var basePath = confUrl;


        if (/^(\/|\\\\)/.test(confUrl)) {

            basePath = /^.+?\w(\/|\\\\)/.exec(docUrl)[0] + confUrl.replace(/^(\/|\\\\)/, '');

        } else if (!/^[a-z]+:/i.test(confUrl)) {

            docUrl = docUrl.split("#")[0].split("?")[0].replace(/[^\\\/]+$/, '');

            basePath = docUrl + "" + confUrl;

        }

        return optimizationPath(basePath);

    }

    function optimizationPath(path) {

        var protocol = /^[a-z]+:\/\//.exec(path)[ 0 ],
            tmp = null,
            res = [];

        path = path.replace(protocol, "").split("?")[0].split("#")[0];

        path = path.replace(/\\/g, '/').split(/\//);

        path[ path.length - 1 ] = "";

        while (path.length) {

            if (( tmp = path.shift() ) === "..") {
                res.pop();
            } else if (tmp !== ".") {
                res.push(tmp);
            }

        }

        return protocol + res.join("/");

    }

    window.UE = {
        getUEBasePath: getUEBasePath
    };

})();
