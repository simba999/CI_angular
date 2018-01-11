! function(e, i, s) {
    "use strict";
    var t = s(i.body),
        n = s(".site-menu"),
        l = s(".site-menubar"),
        o = s('[data-toggle="menubar-fold"]');
    site.menubar = {
        opened: !1,
        folded: !1,
        init: function() {
            var e = Breakpoints.current().name;
            t.is(".menubar-fold") && (this.folded = !0), /xs|sm/.test(e) && !0 === this.folded && t.removeClass("menubar-fold"), !/xs|sm/.test(e) && !1 === this.folded && this.scroll.init(), /md|lg/.test(e) && this.fold(), !/xs|sm/.test(e) && this.menu.addMenuName(), s('[data-toggle="menubar"]').toggleClass("is-active", this.opened), o.toggleClass("is-active", !this.folded)
			},
		fold: function() {
            t.addClass("menubar-fold"), this.scroll.disable(), this.folded = !0, o.toggleClass("is-active", !this.folded)
		},
		unFold: function() {
           !1 === this.scroll.initialized && this.scroll.init(), t.removeClass("menubar-fold"), this.scroll.enable().update(), this.folded = !1, o.toggleClass("is-active", !this.folded)
        },
		toggleFold: function() {
           !0 === this.folded ? this.unFold() : this.fold(), o.toggleClass("is-active", !this.folded)
		},
		hide: function() {
            t.removeClass("menubar-open"), this.opened = !1
		},
		open: function() {
           t.addClass("menubar-open"), this.opened = !0
		},
		toggle: function() {
           !0 === this.opened ? this.hide() : this.open()
        },
        change: function() {
            var e = Breakpoints.current().name;
            /xl/.test(e) ? this.unFold() : /md|lg/.test(e) ? this.fold() : (this.hide(), !0 === this.folded && this.unFold(), this.scroll.disable()), /xs|sm/.test(e) ? this.menu.removeMenuName() : this.menu.addMenuName()
        },
        scroll: {
            initialized: !1,
            enabled: !1,
            $scrollContainer: s("body.menubar-left .site-menubar-inner"),
            init: function() {
                !1 === this.initialized && this.$scrollContainer.slimScroll({
                    height: "auto",
                    position: "right",
                    size: "5px",
                    color: "#98a6ad",
                    wheelStep: 10,
                    touchScrollStep: 50
                }) && (this.initialized = !0, this.enabled = !0)
            },
            update: function() {
                var e = l.height();
                !0 === this.enabled && this.$scrollContainer.height(e).parent().height(e)
            },
            enable: function() {
                return !0 === this.initialized && !1 === this.enabled && this.$scrollContainer.parent().removeClass("disabled").find(".slimScrollBar").css("visibility", "visible"), this.enabled = !0, this
            },
            disable: function() {
                !0 === this.enabled && this.$scrollContainer.parent().addClass("disabled").find(".slimScrollBar").css("visibility", "hidden") && (this.enabled = !1)
            }
        },
        menu: {
            slideSpeed: 500,
            addMenuName: function() {
                n.find(".submenu-fake").length > 0 || n.children("li:not(.menu-section-heading)").each(function() {
                    var e = s(this),
                        i = e.find("> a"),
                        t = i.attr("href"),
                        n = i.find("> .menu-text").text();
                    e.find("> .submenu").length > 0 || e.append('<ul class="submenu submenu-fake"></ul>'), e.find("> .submenu").prepend('<li class="menu-heading"><a href="' + t + '">' + n + "</a></li>")
                })
            },
            removeMenuName: function() {
                n.find(".submenu-fake").remove()
            },
            toggleOnClick: function(e) {
                e.parent().toggleClass("open").find("> .submenu").slideToggle(this.slideSpeed).end().siblings().removeClass("open").find("> .submenu").slideUp(this.slideSpeed)
            },
            toggleOnHover: function(e) {
                /md|lg|xl/.test(Breakpoints.current().name) && e.toggleClass("open").siblings("li").removeClass("open")
            }
        }
    }
}(window, document, jQuery);