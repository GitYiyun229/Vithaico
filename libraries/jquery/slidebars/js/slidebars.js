// Slidebars 0.9 - http://plugins.adchsm.me/slidebars/ Written by Adam Smith - http://www.adchsm.me/ Released under MIT License - http://plugins.adchsm.me/slidebars/license.txt
;(function (a) {
    a.slidebars = function (b) {
        var x = a.extend({
            siteClose: true,
            disableOver: false,
            hideControlClasses: false
        }, b);
        var v = document.createElement("div").style,
            t = false,
            k = false;
        if (v.MozTransition === "" || v.WebkitTransition === "" || v.OTransition === "" || v.transition === "") {
            t = true
        }
        if (v.MozTransform === "" || v.WebkitTransform === "" || v.OTransform === "" || v.transform === "") {
            k = true
        }
        var s = navigator.userAgent,
            y = false,
            c = false;
        if (/Android/.test(s)) {
            y = s.substr(s.indexOf("Android") + 8, 3)
        } else {
            if (/(iPhone|iPod|iPad)/.test(s)) {
                c = s.substr(s.indexOf("OS ") + 3, 3).replace("_", ".")
            }
        } if (y && y < 3 || c && c < 5) {
            a("html").addClass("sb-static")
        }
        if (!a("#sb-site").length) {
            a("body").children().wrapAll('<div id="sb-site" />')
        }
        var q = a("#sb-site");
        if (!q.parent().is("body")) {
            q.appendTo("body")
        }
        if (a(".sb-left").length) {
            var e = a(".sb-left"),
                g = false;
            e.addClass("sb-slidebar");
            if (!e.parent().is("body")) {
                e.appendTo("body")
            }
        }
        if (a(".sb-right").length) {
            var h = a(".sb-right"),
                j = false;
            h.addClass("sb-slidebar");
            if (!h.parent().is("body")) {
                h.appendTo("body")
            }
        }
        var r = false,
            z = a(window).width(),
            w = a(".sb-toggle-left, .sb-toggle-right, .sb-open-left, .sb-open-right, .sb-close"),
            m = a(".sb-slide");

        function o() {
            if (!x.disableOver || (typeof x.disableOver === "number" && x.disableOver >= z)) {
                r = true;
                a("html").addClass("sb-init");
                if (x.hideControlClasses) {
                    w.removeClass("sb-hide")
                }
            } else {
                if (typeof x.disableOver === "number" && x.disableOver < z) {
                    r = false;
                    a("html").removeClass("sb-init");
                    if (x.hideControlClasses) {
                        w.addClass("sb-hide")
                    }
                    if (g || j) {
                        l()
                    }
                }
            }
        }
        o();

        function f() {
            q.css("minHeight", "");
            q.css("minHeight", a("body").height() + "px");
            if (e && (e.hasClass("sb-style-push") || e.hasClass("sb-style-overlay"))) {
                e.css("marginLeft", "-" + e.css("width"))
            }
            if (h && (h.hasClass("sb-style-push") || h.hasClass("sb-style-overlay"))) {
                h.css("marginRight", "-" + h.css("width"))
            }
            if (e && e.hasClass("sb-width-custom")) {
                e.css("width", e.attr("data-sb-width"))
            }
            if (h && h.hasClass("sb-width-custom")) {
                h.css("width", h.attr("data-sb-width"))
            }
        }
        f();
        a(window).resize(function () {
            var A = a(window).width();
            if (z !== A) {
                z = A;
                o();
                f();
                if (g) {
                    i("left")
                }
                if (j) {
                    i("right")
                }
            }
        });
        var u;
        if (t && k) {
            u = "translate";
            if (y && y < 4.4) {
                u = "side"
            }
        } else {
            u = "jQuery"
        }

        function d(B, E, D) {
            var A;
            if (B.hasClass("sb-style-push")) {
                A = q.add(B).add(m)
            } else {
                if (B.hasClass("sb-style-overlay")) {
                    A = B
                } else {
                    A = q.add(m)
                }
            } if (u === "translate") {
				if(E == '0px'){					
					A.css("transform", "");
				}else{
					A.css("transform", "translate(" + E + ")")
				}
                
            } else {
                if (u === "side") {
                    if (E[0] === "-") {
                        E = E.substr(1)
                    }
                    A.css(D, E);
                    setTimeout(function () {
                        if (E === "0px") {
                            A.removeAttr("style");
                            f()
                        }
                    }, 400)
                } else {
                    if (u === "jQuery") {
                        if (E[0] === "-") {
                            E = E.substr(1)
                        }
                        var C = {};
                        C[D] = E;
                        A.stop().animate(C, 400);
                        setTimeout(function () {
                            if (E === "0px") {
                                A.removeAttr("style");
                                f()
                            }
                        }, 400)
                    }
                }
            }
        }

        function i(A) {
            if (A === "left" && e && j || A === "right" && h && g) {
                l();
                setTimeout(B, 400)
            } else {
                B()
            }

            function B() {
                if (r && A === "left" && e) {
                    a("html").addClass("sb-active sb-active-left");
                    e.addClass("sb-active");
                    d(e, e.css("width"), "left");
                    setTimeout(function () {
                        g = true
                    }, 400)
                } else {
                    if (r && A === "right" && h) {
                        a("html").addClass("sb-active sb-active-right");
                        h.addClass("sb-active");
                        d(h, "-" + h.css("width"), "right");
                        setTimeout(function () {
                            j = true
                        }, 400)
                    }
                }
            }
        }

        function l(A) {
            if (g || j) {
                if (g) {
                    d(e, "0px", "left");
                    g = false
                }
                if (j) {
                    d(h, "0px", "right");
                    j = false
                }
                setTimeout(function () {
                    a("html").removeClass("sb-active sb-active-left sb-active-right");
                    if (e) {
                        e.removeClass("sb-active")
                    }
                    if (h) {
                        h.removeClass("sb-active")
                    }
                    if (A) {
                        window.location = A
                    }
                }, 400)
            }
        }

        function n(A) {
            if (A === "left" && e) {
                if (!g) {
                    i("left")
                } else {
                    l()
                }
            }
            if (A === "right" && h) {
                if (!j) {
                    i("right")
                } else {
                    l()
                }
            }
        }
        this.open = i;
        this.close = l;
        this.toggle = n;
        this.init = function () {
            return r
        };
        this.active = function (A) {
            if (A === "left" && e) {
                return g
            }
            if (A === "right" && h) {
                return j
            }
        };

        function p(B, A) {
            B.stopPropagation();
            B.preventDefault();
            if (B.type === "touchend") {
                A.off("click")
            }
        }
        a(".sb-toggle-left").on("touchend click", function (A) {
            p(A, a(this));
            n("left")
        });
        a(".sb-toggle-right").on("touchend click", function (A) {
            p(A, a(this));
            n("right")
        });
        a(".sb-open-left").on("touchend click", function (A) {
            p(A, a(this));
            i("left")
        });
        a(".sb-open-right").on("touchend click", function (A) {
            p(A, a(this));
            i("right")
        });
        a(".sb-close").on("touchend click", function (A) {
            p(A, a(this));
            l()
        });
        a(".sb-slidebar a").not(".sb-disable-close").on("click", function (A) {
            p(A, a(this));
            l(a(this).attr("href"))
        });
        q.on("touchend click", function (A) {
            if (x.siteClose && (g || j)) {
                p(A, a(this));
                l()
            }
        })
    }
})(jQuery);