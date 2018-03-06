/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function( $ ) {
	var container, button, primary_menu, menu, links, i, len, has_children, link, children,
		custom_logo,
		avatar,
                home,
                templateUrl;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	primary_menu = document.getElementById( 'primary-menu' );
	menu = container.getElementsByTagName( 'ul' )[0];
        console.log(primary_menu);
        console.log(menu);
        console.log(button);
	has_children = container.getElementsByClassName( 'page_item_has_children' );
        has_children = container.getElementsByClassName( 'menu-item-has-children' );
	children = container.getElementsByClassName( 'children' );
        children = container.getElementsByClassName( 'sub-menu' );	
	
	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}
        
        // Add a link to site url
//        templateUrl = document.location.origin+document.location.pathname;        
//        console.log( document.baseURI );
//        home = '<li><a href="' + templateUrl + '">Home</a></li>'
//        $(menu).prepend(home);
        
	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav navbar-nav' ) ) {
		menu.className += ' nav navbar-nav';
	}

	for ( i = 0; i < has_children.length; i++ ) {		
			has_children[i].className += ' dropdown';
			link = $(has_children[i]).children('a');
			link.attr( 'aria-expanded', 'false' );
			link.addClass( 'dropdown-toggle' );
			link.attr( 'data-toggle', 'dropdown' );
			link.attr( 'role', 'button' );
			link.attr( 'aria-haspopup', 'true' );
			link.append('<span class="caret"></span>');
	}

	for ( i = 0; i < children.length; i++ ) {
		if ( -1 === children[i].className.indexOf( 'dropdown-menu' ) ) {
			//$(children[i]).before('<span class="caret"></span>');
			children[i].className += ' dropdown-menu';
		}
	}

	button.onclick = function() {
		if ( primary_menu.classList.contains( 'in' ) ) {
			primary_menu.className = primary_menu.className.replace( ' in', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			primary_menu.className += ' in';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// has_children.onclick = function() {
	// 	console.log('initiated');
	// 	if ( -1 !== has_children.className.indexOf( 'open-a' ) ) {
	// 		console.log('true');
	// 		has_children.className = has_children.className.replace( ' open-a', '' );
	// 		// button.setAttribute( 'aria-expanded', 'false' );
	// 		// menu.setAttribute( 'aria-expanded', 'false' );
	// 	} else {
	// 		console.log('false');
	// 		has_children.className += ' open-a';
	// 		// button.setAttribute( 'aria-expanded', 'true' );
	// 		// menu.setAttribute( 'aria-expanded', 'true' );
	// 	}
	// }

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'navbar-nav' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {

					if ( ! $(self).find('.children .children').length ) {
						self.className = self.className.replace( ' focus', '' );
					} else {
						self.classList.add( 'open' );
					}
					//self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
					//self.className += ' open';
				}
			}

			self = self.parentElement;
		}
	}

	// Add class 'aligncenter' to Custom Logo
	custom_logo = document.getElementsByClassName( 'custom-logo' );
	$(custom_logo).addClass('aligncenter');

	// Add class 'img-responsive' to Custom Logo
	avatar = document.getElementsByClassName( 'avatar' );
	$(avatar).addClass('img-responsive');

} )( jQuery );
