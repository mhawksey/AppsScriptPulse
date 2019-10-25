=== Simple Author Box ===
Contributors: machothemes, silkalns
Tags: author box, responsive author box, author profile fields, author social icons, profile fields, author bio, author description, author profile, post author, rtl author box, amp, accelerated mobile pages
Requires at least: 4.6
Requires PHP: 5.6
Stable tag: 2.3.2
Tested up to: 5.2
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Adds a cool responsive author box with social icons on your posts.

== Description ==

**Simple Author Box** is a standalone plugin built, maintained & operated by the friendly folks over at [MachoThemes](https://www.machothemes.com/)

**Simple Author Box** adds a responsive author box at the end of your posts, showing the author name, author gravatar and author description. It also adds over 30 social profile fields on WordPress user profile screen, allowing to display the author social icons.

= Main Features =

* Shows author gravatar, name, website, description and social icons
* Fully customizable to match your theme design (style, color, size and text options)
* Nice looking on desktop, laptop, tablet or mobile phones
* Automatically insert the author box at the end of your post
* Option to manually insert the author box on your template file (single.php or author.php)
* Simple Author Box has RTL support
* Simple Author Box has AMP support

= Simple Author Box Pro Features =

> **Premium features only available in Simple Author Box Pro:**
>
> * Change author box position to before/after content
> * Choose whether the author's name should link to its website/page/none
> * Select where to show author box on
> * Add rotate effect on author avatar hover
> * Option to open author website link in a new tab
> * Option to add "nofollow" attribute on author website link
> * Choose the author website's position: right/left
> * Social icons type, style, rotate effect, shadow effect, thin border
> * Option to change the color palette
> * Choose the font and font sizes for the author's job title, website, name, and description
> * Enable guest authors and co-authors
> * Option to use guest authors as co-authors
> * Top authors widget - displays the most popular authors based of comments
> * Simple author box widget - displays the users selected
>
>**[Learn more about Simple Author Box Pro.](https://www.machothemes.com/item/simple-author-box-pro?utm_source=wordpress.org&utm_medium=web&utm_campaign=SABLITE)**

**About us:**
We are a young team of WordPress aficionados who love building WordPress plugins & <a href="https://www.machothemes.com/" target="_blank" title="Premium WordPress themes">Premium WordPress themes</a> over on our theme shop. We’re also blogging and wish to help our users find the best <a href="https://www.machothemes.com/blog/cheap-wordpress-hosting/" target="_blank" title="Cheap WordPress Hosting">Cheap WordPress hosting</a>.

== Installation ==

1. Download the plugin (.zip file) on your hard drive.
2. Unzip the zip file contents.
3. Upload the `simple-author-box` folder to the `/wp-content/plugins/` directory.
4. Activate the plugin through the 'Plugins' menu in WordPress.
5. A new sub menu item `Simple Author Box` will appear in your main Settings menu.

== Frequently Asked Questions ==

= Why does the author box not display on a page? =

The Simple Author Box plugin was designed to display the author information on posts, categories, tags, etc. The plugin does not work on pages – it was not designed for this, unfortunately. Adding the shortcode on a blog page will also not work because the plugin won’t have author information to display/will not know which author information to display. Adding the shortcode in a widget that is on a page is another instance when the SAB will not be displayed due to the same reasons. You can add it in a widget, but that widget has to be on a single post.

= What should I add for Whatsapp ? =

You should add there your phone number, for more information read <a href="https://faq.whatsapp.com/en/android/26000030/" target="_blank">this</a>

= What should I add for Telegram ? =

You should add there your username, for more information read <a href="https://telegram.org/faq#q-how-does-t-me-work" target="_blank">this</a>

= Can I remove the SAB from WooCommerce/Category/Tags pages? Can I have only on posts? =

The PRO version of Simple Author Box fixes this.

= Is there any widget in Simple Author Box ? =

Yes, but we also have two awesome widgets in the PRO version.

= I have two author boxes. How can I hide one? =

The second author box might be a theme feature and you will need to turn it off from your theme’s options, or hide it with custom CSS.

= How I can translate the author's biography ? =

You can use 2 plugins in order to do this: Polylang or WPML. Here it is how to translate an author's biography with each plugin:

**Polylang**
When using Polylang a "Biographical Info" textarea is added for each language, this way you can enter the "Biographical Info" for each respective language.

**WPML**
In order to translate the "Biographical Info" using this plugin you have to have the wpml-string-translation plugin installed and the following configurations made:
In the String Translation settings at the bottom you will see a "More options" setting. Click "Edit" then select "Author" from there and finally click "Apply". After this, in the filters above, at "Select strings within domain" select "Authors". This will reveal the strings that can be translated from the author role.

= How can I use it with Content Blocks (Custom Post Widget) ? =

When adding a widget in the widget area you can select the content block to display and there you will also see a checkbox titled "Do not apply content filters". Checking this checkbox will prevent the author box from displaying for that custom post.
When using a shortcode, example [content_block id=41] you can stop the author box from displaying by using one of these shortocodes instead: [content_block id=41 suppress_content_filters=true] or [content_block id=41 suppress_filters=true], both work.

= How can I get support? =

You can get free support either here on the support forums: <a href="https://wordpress.org/support/plugin/simple-author-box">https://wordpress.org/support/plugin/simple-author-box</a>
Or if you send us an email at <a href="mailto:support@machothemes.com">support@machothemes.com</a>

= How can I say thanks? =

You can say thank you by leaving us a review here: <a href="https://wordpress.org/support/plugin/simple-author-box/reviews/#new-post">https://wordpress.org/support/plugin/simple-author-box/reviews/#new-post</a>
Or you can give back by recommending this amazing plugin to your friends!


== Screenshots ==

1. Simple Author Box - Colored icons - squares
2. Simple Author Box - Colored icons - circles
3. Simple Author Box - Grey icons - author square
4. Simple Author Box - Grey icons - author circle
5. Simple Author Box - White icons - grey background
6. Simple Author Box - White icons - blue background
7. Simple Author Box - RTL view 1
8. Simple Author Box - RTL view 2
9. Simple Author Box - Sample 2
10. Simple Author Box - Sample 1
11. Simple Author Box - Responsive view 1
12. Simple Author Box - Responsive view 2
13. Simple Author Box - Responsive view 3
14. Plugin options page, simple view (v1.2)

== Changelog ==

See <a href="https://github.com/MachoThemes/simple-author-box/blob/master/changelog.txt" target="_blank">changelog</a>
