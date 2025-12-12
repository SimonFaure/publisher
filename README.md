# Publisher Pro - WooCommerce Theme

A professional WordPress theme designed specifically for publishers, featuring author showcases, book previews, series management, and advanced filtering capabilities.

## Features

### Product Management
- Support for multiple product types: Physical Books, eBooks, Audiobooks, Posters/Art, and Board Games
- Custom product fields for books (ISBN, page count, publication date, dimensions)
- Downloadable product support for eBook versions and additional files (book covers, sample chapters)
- Product badges for new releases and sale items

### Author Showcase System
- Custom "Author" post type with dedicated profile pages
- Author meta fields: website, Twitter, Facebook, Instagram
- Author archive page with grid layout
- Individual author pages with biography and bibliography
- Automatic relationship between authors and products

### Book Preview & Sample Chapters
- Custom meta boxes for uploading preview content
- Support for both text content and PDF previews
- Modal popup for reading samples
- "Read Sample" button prominently displayed on product pages

### Series & Collection Management
- Custom "Series" taxonomy for grouping related books
- Series archive pages showing all books in order
- Series navigation on product pages
- Series filtering in shop pages

### Genre Management
- Custom "Genre" taxonomy for categorizing books
- Genre archive pages
- Genre filtering in shop and search

### Advanced Search & Filtering
- AJAX-powered product filtering by Genre, Author, Series
- Multiple sort options (newest, price, alphabetical)
- Active filter display with remove functionality
- Persistent search functionality

### Design & Styling
- Mobile-first responsive design
- Classic bookstore aesthetic
- Color scheme inspired by Poids-Plume Editions:
  - Primary accent: Lime green (#9af720)
  - Soft lime buttons (#c9f78d)
  - Clean white backgrounds
  - Professional typography (Roboto + Merriweather)
- Sticky header with search and cart
- Smooth animations and transitions

### Homepage Features
- Hero section with call-to-action
- Featured product categories grid
- New releases section
- Featured authors showcase
- Featured series display
- Newsletter signup area (widget ready)

### WooCommerce Integration
- Full WooCommerce support
- Custom product templates
- Enhanced single product page with tabs:
  - Description
  - Book Details
  - About the Author
  - Reviews
- Cart and checkout page styling
- My Account page layout
- Breadcrumb navigation

## Installation

1. Upload the theme folder to `/wp-content/themes/`
2. Activate the theme through the WordPress admin panel
3. Install and activate WooCommerce plugin
4. Configure WooCommerce settings
5. Go to Settings > Permalinks and click "Save Changes" to flush rewrite rules

## Required Plugins

- **WooCommerce** (required) - For e-commerce functionality

## Theme Setup

### 1. Create Product Categories

Create the following product categories in WooCommerce:
- Books
- eBooks
- Audiobooks
- Board Games
- Art & Posters

### 2. Add Authors

1. Go to Authors in the WordPress admin
2. Add new authors with:
   - Name (title)
   - Biography (content)
   - Profile photo (featured image)
   - Social media links (in Author Details meta box)

### 3. Create Genres

1. Go to Products > Genres
2. Add genres for your books (e.g., Fiction, Non-fiction, Mystery, Romance, etc.)

### 4. Create Series

1. Go to Products > Series
2. Add series/collections for grouped books

### 5. Add Products

1. Create products in WooCommerce
2. Fill in the Book Details:
   - Select Author
   - Enter ISBN
   - Add page count
   - Set publication date
   - Add dimensions
3. Add Book Preview content or PDF
4. Assign Genre and Series taxonomies
5. Set product category (Books, eBooks, etc.)

### 6. Configure Menus

1. Go to Appearance > Menus
2. Create a Primary Menu and assign it to "Primary Menu" location
3. Create a Footer Menu and assign it to "Footer Menu" location

### 7. Set Homepage

1. Create a new page titled "Home"
2. Go to Settings > Reading
3. Select "A static page" and choose "Home" as your homepage

### 8. Customize Footer

1. Go to Appearance > Customize
2. Add illustrator credit text if desired

## Custom Fields Guide

### Author Meta Fields
- **Website**: Author's personal website URL
- **Twitter**: Twitter username (without @)
- **Facebook**: Facebook username or page name
- **Instagram**: Instagram username (without @)

### Product Meta Fields (Books)
- **Book Author**: Select from Authors post type
- **ISBN**: International Standard Book Number
- **Number of Pages**: Total page count
- **Publication Date**: Date the book was published
- **Dimensions**: Physical dimensions (e.g., "6 x 9 inches")

### Book Preview Fields
- **Preview Text Content**: Enter sample chapter text
- **Preview PDF URL**: Upload a PDF file for preview

## Customization

### Colors

Edit the color variables in `style.css`:
```css
:root {
    --color-primary: #9af720;
    --color-primary-soft: #c9f78d;
    --color-primary-hover: #aef74f;
    --color-text: #616161;
    --color-text-dark: #222222;
    --color-background: #ffffff;
    --color-border: #b1a6a6c2;
}
```

### Typography

The theme uses:
- **Body text**: Roboto (Google Fonts)
- **Headings**: Merriweather (Google Fonts)

To change fonts, edit the font imports in `functions.php` and update the CSS variables.

### Spacing

The theme uses a consistent spacing system. Adjust in `style.css`:
```css
:root {
    --spacing-xs: 0.5rem;
    --spacing-sm: 1rem;
    --spacing-md: 1.5rem;
    --spacing-lg: 2rem;
    --spacing-xl: 3rem;
    --spacing-xxl: 4rem;
}
```

## File Structure

```
publisher-pro/
├── assets/
│   ├── css/
│   │   ├── main.css
│   │   └── woocommerce.css
│   └── js/
│       └── main.js
├── woocommerce/
│   ├── archive-product.php
│   ├── content-product.php
│   └── content-single-product.php
├── 404.php
├── archive-book_author.php
├── footer.php
├── front-page.php
├── functions.php
├── header.php
├── index.php
├── page.php
├── README.md
├── searchform.php
├── single-book_author.php
├── style.css
├── taxonomy-book_genre.php
└── taxonomy-book_series.php
```

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Credits

- Design inspired by [Poids-Plume Editions](https://poidsplume-editions.com/)
- Built with WordPress and WooCommerce
- Fonts: Roboto and Merriweather from Google Fonts

## Support

For theme support and customization requests, please contact the theme developer.

## Changelog

### Version 1.0.0
- Initial release
- Author showcase system
- Book preview functionality
- Series and genre management
- Advanced filtering
- Mobile-first responsive design
- Full WooCommerce integration
