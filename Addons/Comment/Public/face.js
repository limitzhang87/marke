/*! CHANGYAN2 2015-08-26 */
seajs.define("face",
function(require, exports, module) {
    var $ = require("jquery"),
    a = require("scsUtil"),
    b = {
        wrapper: "",
        name: "sc",
        faceShow: !1,
        $textInput: {},
        $face: {},
        faceUrl: "http://changyan.itc.cn/v2/asset/scs/imgs/new_face/",
        sohuFaceUrl: "http://comment.news.sohu.com/upload/comment4_1/images/face2013/",
        faceFrag: '<div class="face-frag" class="face_wrapper"></div>',
        imgData: {
            "/流汗": ["new_face_01", "流汗"],
            "/钱": ["new_face_02", "钱"],
            "/发怒": ["new_face_03", "发怒"],
            "/浮云": ["new_face_04", "浮云"],
            "/给力": ["new_face_05", "给力"],
            "/大哭": ["new_face_06", "大哭"],
            "/憨笑": ["new_face_07", "憨笑"],
            "/色": ["new_face_08", "色"],
            "/奋斗": ["new_face_09", "奋斗"],
            "/鼓掌": ["new_face_10", "鼓掌"],
            "/鄙视": ["new_face_11", "鄙视"],
            "/可爱": ["new_face_12", "可爱"],
            "/闭嘴": ["new_face_13", "闭嘴"],
            "/疑问": ["new_face_14", "疑问"],
            "/抓狂": ["new_face_15", "抓狂"],
            "/惊讶": ["new_face_16", "惊讶"],
            "/可怜": ["new_face_17", "可怜"],
            "/弱": ["new_face_18", "弱"],
            "/强": ["new_face_19", "强"],
            "/握手": ["new_face_20", "握手"],
            "/拳头": ["new_face_21", "拳头"],
            "/酒": ["new_face_22", "酒"],
            "/玫瑰": ["new_face_23", "玫瑰"],
            "/打酱油": ["new_face_24", "打酱油"],
            "开心": ["4_t", "sohu"],
            "赞": ["13_t", "sohu"],
            "正能量": ["14_t", "sohu"],
            "鼓掌": ["1_t", "sohu"],
            "草泥马": ["8_t", "sohu"],
            "愤怒": ["10_t", "sohu"],
            "鄙视": ["9_t", "sohu"],
            "可怜": ["6_t", "sohu"],
            "蜡烛": ["12_t", "sohu"],
            "流泪": ["3_t", "sohu"],
            "震惊": ["5_t", "sohu"],
            "恐怖": ["15_t", "sohu"],
            "呵呵": ["7_t", "sohu"],
            "无语": ["2_t", "sohu"],
            "打酱油": ["4_t", "sohu"]
        },
        init: function(b, c, d) {
            var e = this,
            f = b.find(".face-wrapper-dw");
            return e.pos = d,
            e.$textInput = b.find(".area-textarea-w textarea"),
            e.$cbox = b,
            f.length ? (f.show(), e._appendToPage(c), e.faceShow = !0, void e._faceEvent()) : (e.appendFaceHtml(b, c), e._faceEvent(), e._appendToPage(c), e.faceShow = !0, void a.objectAVoid())
        },
        _faceEvent: function() {
            var a = this,
            b = a.$textInput,
            c = $(".face-wrapper-dw");
            c.unbind("click"),
            c.bind("click",
            function(d) {
                var e = $(d.target || d.srcElement);
                if ("IMG" == e[0].nodeName) var f = e.closest("a"),
                g = f.attr("data_ubb");
                else {
                    if ("A" != e[0].nodeName) return;
                    var g = e.attr("data_ubb")
                }
                b.val() == decodeURIComponent(SOHUCS.config.sys.module.cbox.defaultTxt) && b.val("");
                var h = b.val(),
                i = a.pos,
                j = h.substring(0, i) + "[" + g + "]",
                k = h.substring(i);
                if (b.val(j + k), c.hide(), a.faceShow = !1, b[0].setSelectionRange) b[0].setSelectionRange(j.length, j.length);
                else {
                    var l = b[0].createTextRange(),
                    m = j.length;
                    l.collapse(!0),
                    l.moveStart("character", m),
                    l.select()
                }
                b.focus();
                var n = c.closest(".action-function-w"),
                o = n.find(".wrapper-image-dw:visible").length > 0 ? n.find(".wrapper-image-dw:visible") : c,
                p = n.position(),
                q = parseInt(p.top) + parseInt(o.height()) + 65;
                a.resetHeight(!0, q)
            }),
            a.resetHeight()
        },
        resetHeight: function(b, c) {
            a.resetIframeHeight(b, c)
        },
        ubbToImg: function(a) {
            var c = b,
            d = "";
            return d = a.replace(/\[([^\]]+)\]+?/g,
            function(a, b) {
                var d = c.imgData[b];
                return d && "undefined" != typeof d ? "sohu" == d[1] ? '<img src="' + c.sohuFaceUrl + d[0] + '.gif" alt="' + b + '" title="' + b + '">': "sohu" != d[1] ? '<img src="' + c.faceUrl + d[0] + '.gif" alt="' + d[1] + '" title="' + d[1] + '" ubb="' + b + '">': a: a
            })
        },
        _appendToPage: function(a) {
            var b, c = $(a.target).parents("li"),
            d = c.closest(".action-function-w"),
            e = d.position(),
            f = c.height() + 1,
            g = c.position(),
            h = {};
            h.left = g.left - 2,
            c.closest(".wrap-reply-gw").length ? h.top = g.top + 30 : h.top = g.top + f;
            var i = c.closest(".action-function-w").find(".face-wrapper-dw");
            i.css({
                top: h.top,
                left: h.left
            });
            var j = d.find(".wrapper-image-dw:visible").length > 0 ? d.find(".wrapper-image-dw:visible") : i;
            b = parseInt(e.top) + parseInt(j.height()) + 65,
            this.resetHeight(!0, b)
        },
        getCursortPosition: function(a) {
            var b = {
                text: "",
                start: 0,
                end: 0
            };
            if (a.blur(), a.focus(), a.setSelectionRange) b.start = a.selectionStart,
            b.end = a.selectionEnd,
            b.text = b.start != b.end ? a.value.substring(b.start, b.end) : "";
            else if (document.selection) {
                var c, d = document.selection.createRange(),
                e = document.body.createTextRange();
                for (e.moveToElementText(a), b.text = d.text, b.bookmark = d.getBookmark(), c = 0; e.compareEndPoints("StartToStart", d) < 0 && 0 !== d.moveStart("character", -1); c++)"\n" == a.value.charAt(c) && c++;
                b.start = c,
                b.end = b.text.length + b.start
            }
            return b
        },
        hideFaceWrapper: function(a) {
            var b = $("body .face-wrapper-dw"),
            a = a || window.event,
            c = this;
            if (a) {
                var d = a.target || a.srcElement;
                if ($(d).closest(".face-wrapper-dw").length) return
            }
            if (b.find(".wrapper-cont-dw").length > 0 && c.faceShow) {
                var e = b.closest(".action-function-w"),
                f = e.find(".wrapper-image-dw:visible").length > 0 ? e.find(".wrapper-image-dw:visible") : b,
                g = e.position(),
                h = parseInt(g.top) + parseInt(f.height()) + 65;
                b.hide(),
                c.faceShow = !1,
                0 == $(d).closest("#user_page").length ? c.resetHeight(!0, h) : c.resetHeight()
            }
        },
        appendFaceHtml: function(a, b) {
            var c = a.find(".action-function-w"),
            d = this.faceUrl;
            c.append('<div class="reset-g windows-define-dg face-wrapper-dw" ><div class="wrapper-cont-dw wrapper-cont-bd"><ul class="clear-g"><li><a data_ubb="/流汗" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_01.gif" alt="流汗" title="流汗"></a></li><li><a data_ubb="/钱" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_02.gif" alt="钱" title="钱"></a></li><li><a data_ubb="/发怒" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_03.gif" alt="发怒" title="发怒"></a></li><li><a data_ubb="/浮云" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_04.gif" alt="浮云" title="浮云"></a></li><li><a data_ubb="/给力" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_05.gif" alt="给力" title="给力"></a></li><li><a data_ubb="/大哭" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_06.gif" alt="大哭" title="大哭"></a></li><li><a data_ubb="/憨笑" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_07.gif" alt="憨笑" title="憨笑"></a></li><li><a data_ubb="/色" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_08.gif" alt="色" title="色"></a></li></ul><ul class="clear-g"><li><a data_ubb="/奋斗" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_09.gif" alt="奋斗" title="奋斗"></a></li><li><a data_ubb="/鼓掌" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_10.gif" alt="鼓掌" title="鼓掌"></a></li><li><a data_ubb="/鄙视" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_11.gif" alt="鄙视" title="鄙视"></a></li><li><a data_ubb="/可爱" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_12.gif" alt="可爱" title="可爱"></a></li><li><a data_ubb="/闭嘴" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_13.gif" alt="闭嘴" title="闭嘴"></a></li><li><a data_ubb="/疑问" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_14.gif" alt="疑问" title="疑问"></a></li><li><a data_ubb="/抓狂" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_15.gif" alt="抓狂" title="抓狂"></a></li><li><a data_ubb="/惊讶" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_16.gif" alt="惊讶" title="惊讶"></a></li></ul><ul class="clear-g"><li><a data_ubb="/可怜" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_17.gif" alt="可怜" title="可怜"></a></li><li><a data_ubb="/弱" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_18.gif" alt="弱" title="弱"></a></li><li><a data_ubb="/强" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_19.gif" alt="强" title="强"></a></li><li><a data_ubb="/握手" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_20.gif" alt="握手" title="握手"></a></li><li><a data_ubb="/拳头" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_21.gif" alt="拳头" title="拳头"></a></li><li><a data_ubb="/酒" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_22.gif" alt="酒" title="酒"></a></li><li><a data_ubb="/玫瑰" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_23.gif" alt="玫瑰" title="玫瑰"></a></li><li><a data_ubb="/打酱油" data_path="base" href="javascript:void(0)"><img src="' + d + 'new_face_24.gif" alt="打酱油" title="打酱油"></a></li></ul></div></div>')
        }
    };
    module.exports = b,
    $("body").click(function(a) {
        $(".clear-g .function-face-w").removeClass("function-e"),
        b.hideFaceWrapper(a)
    })
});