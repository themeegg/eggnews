<?php
/**
 * EggNews Admin Class.
 *
 * @author  ThemeEgg
 * @package EggNews
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'EggNews_Admin' ) ) :

	/**
	 * EggNews_Admin Class.
	 */
	class EggNews_Admin {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'wp_loaded', array( __CLASS__, 'hide_notices' ) );
			add_action( 'load-themes.php', array( $this, 'admin_notice' ) );
		}

		/**
		 * Add admin menu.
		 */
		public function admin_menu() {
			$theme = wp_get_theme( get_template() );

			$page = add_theme_page( esc_html__( 'About', 'eggnews' ) . ' ' . $theme->display( 'Name' ), esc_html__( 'About', 'eggnews' ) . ' ' . $theme->display( 'Name' ), 'activate_plugins', 'eggnews-welcome', array(
				$this,
				'welcome_screen'
			) );
			add_action( 'admin_print_styles-' . $page, array( $this, 'enqueue_styles' ) );
		}

		/**
		 * Enqueue styles.
		 */
		public function enqueue_styles() {
			global $eggnews_version;

			wp_enqueue_style( 'eggnews-welcome-admin', get_template_directory_uri() . '/inc/admin/css/welcome-admin.css', array(), $eggnews_version );
		}

		/**
		 * Add admin notice.
		 */
		public function admin_notice() {
			global $eggnews_version, $pagenow;
			wp_enqueue_style( 'eggnews-message', get_template_directory_uri() . '/inc/admin/css/admin-notices.css', array(), $eggnews_version );

			// Let's bail on theme activation.
			if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
				add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
				update_option( 'eggnews_admin_notice_welcome', 1 );

				// No option? Let run the notice wizard again..
			} elseif ( ! get_option( 'eggnews_admin_notice_welcome' ) ) {
				add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
			}
		}

		/**
		 * Hide a notice if the GET variable is set.
		 */
		public static function hide_notices() {
			if ( isset( $_GET['eggnews-hide-notice'] ) && isset( $_GET['_eggnews_notice_nonce'] ) ) {
				if ( ! wp_verify_nonce( wp_unslash( $_GET['_eggnews_notice_nonce'] ), 'eggnews_hide_notices_nonce' ) ) {
					wp_die( esc_html__( 'Action failed. Please refresh the page and retry.', 'eggnews' ) );
				}

				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( esc_html__( 'Cheatin&#8217; huh?', 'eggnews' ) );
				}

				$hide_notice = sanitize_text_field( wp_unslash( $_GET['eggnews-hide-notice'] ) );
				update_option( 'eggnews_admin_notice_' . $hide_notice, 1 );
			}
		}

		/**
		 * Show welcome notice.
		 */
		public function welcome_notice() {
			?>
			<div id="message" class="updated eggnews-message">
				<a class="eggnews-message-close notice-dismiss"
				   href="<?php echo esc_url( wp_nonce_url( remove_query_arg( array( 'activated' ), add_query_arg( 'eggnews-hide-notice', 'welcome' ) ), 'eggnews_hide_notices_nonce', '_eggnews_notice_nonce' ) ); ?>"><?php esc_html_e( 'Dismiss', 'eggnews' ); ?></a>
				<p><?php
					/* translators: 1: anchor tag start, 2: anchor tag end*/
					printf( esc_html__( 'Welcome! Thank you for choosing eggnews! To fully take advantage of the best our theme can offer please make sure you visit our %1$swelcome page%1$s.', 'eggnews' ), '<a href="' . esc_url( admin_url( 'themes.php?page=eggnews-welcome' ) ) . '">', '</a>' );
					?></p>
				<p class="submit">
					<a class="button-secondary"
					   href="<?php echo esc_url( admin_url( 'themes.php?page=eggnews-welcome' ) ); ?>"><?php esc_html_e( 'Get started with EggNews', 'eggnews' ); ?></a>
				</p>
			</div>
			<?php
		}

		/**
		 * Intro text/links shown to all about pages.
		 *
		 * @access private
		 */
		private function intro() {
			global $eggnews_version;
			$theme = wp_get_theme( get_template() );

			// Drop minor version if 0
			$major_version = substr( $eggnews_version, 0, 3 );
			?>
			<div class="eggnews-theme-info">
				<h1>
					<?php esc_html_e( 'About', 'eggnews' ); ?>
					<?php echo esc_html( $theme->display( 'Name' ) ); ?>
					<?php printf( '%s', $major_version ); ?>
				</h1>

				<div class="welcome-description-wrap">
					<div class="about-text"><?php echo esc_html( $theme->display( 'Description' ) ); ?></div>

					<div class="eggnews-screenshot">
						<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.png'; ?>"/>
					</div>
				</div>
			</div>

			<p class="eggnews-actions">
				<a href="<?php echo esc_url( 'http://themeegg.com/themes/eggnews/' ); ?>"
				   class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'eggnews' ); ?></a>

				<a href="<?php echo esc_url( apply_filters( 'eggnews_theme_url', 'http://demo.themeegg.com/themes/eggnews/' ) ); ?>"
				   class="button button-secondary docs"
				   target="_blank"><?php esc_html_e( 'View Demo', 'eggnews' ); ?></a>

				<a href="<?php echo esc_url( apply_filters( 'eggnews_rate_url', 'https://wordpress.org/support/view/theme-reviews/eggnews?filter=5#postform' ) ); ?>"
				   class="button button-secondary docs"
				   target="_blank"><?php esc_html_e( 'Rate this theme', 'eggnews' ); ?></a>
				<a href="<?php echo esc_url( apply_filters( 'eggnews_pro_theme_url', 'https://themeegg.com/downloads/eggnews-pro-wordpress-theme/' ) ); ?>"
				   class="button button-primary docs"
				   target="_blank"><?php esc_html_e( 'View Pro Version', 'eggnews' ); ?></a>
			</p>

			<h2 class="nav-tab-wrapper">
				<a class="nav-tab <?php if ( empty( $_GET['tab'] ) && $_GET['page'] == 'eggnews-welcome' ) {
					echo 'nav-tab-active';
				} ?>"
				   href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'eggnews-welcome' ), 'themes.php' ) ) ); ?>">
					<?php echo $theme->display( 'Name' ); ?>
				</a>
				<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'changelog' ) {
					echo 'nav-tab-active';
				} ?>" href="<?php echo esc_url( admin_url( add_query_arg( array(
					'page' => 'eggnews-welcome',
					'tab'  => 'changelog'
				), 'themes.php' ) ) ); ?>">
					<?php esc_html_e( 'Changelog', 'eggnews' ); ?>
				</a>
				<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'freevspro' ) {
					echo 'nav-tab-active';
				} ?>" href="<?php echo esc_url( admin_url( add_query_arg( array(
					'page' => 'eggnews-welcome',
					'tab'  => 'freevspro'
				), 'themes.php' ) ) ); ?>">
					<?php esc_html_e( 'Free Vs Pro', 'eggnews' ); ?>
				</a>
			</h2>
			<?php
		}

		/**
		 * Welcome screen page.
		 */
		public function welcome_screen() {
			$current_tab = empty( $_GET['tab'] ) ? 'about' : sanitize_title( wp_unslash( $_GET['tab'] ) );

			// Look for a {$current_tab}_screen method.
			if ( is_callable( array( $this, $current_tab . '_screen' ) ) ) {
				return $this->{$current_tab . '_screen'}();
			}

			// Fallback to about screen.
			return $this->about_screen();
		}

		/**
		 * Output the about screen.
		 */
		public function about_screen() {
			$theme = wp_get_theme( get_template() );
			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<div class="changelog point-releases">
					<div class="under-the-hood two-col">

						<div class="col">
							<h3><?php esc_html_e( 'Theme Customizer', 'eggnews' ); ?></h3>
							<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'eggnews' ) ?></p>
							<p><a href="<?php echo admin_url( 'customize.php' ); ?>"
							      class="button button-secondary"><?php esc_html_e( 'Customize', 'eggnews' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3><?php esc_html_e( 'Documentation', 'eggnews' ); ?></h3>
							<p><?php esc_html_e( 'Please view our documentation page to setup the theme.', 'eggnews' ) ?></p>
							<p><a href="<?php echo esc_url( 'http://docs.themeegg.com/docs/eggnews/' ); ?>"
							      class="button button-secondary"><?php esc_html_e( 'Documentation', 'eggnews' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3><?php esc_html_e( 'Got theme support question?', 'eggnews' ); ?></h3>
							<p><?php esc_html_e( 'Please put it in our dedicated support forum.', 'eggnews' ) ?></p>
							<p><a href="<?php echo esc_url( 'https://themeegg.com/support-forum' ); ?>"
							      class="button button-secondary"><?php esc_html_e( 'Support', 'eggnews' ); ?></a></p>
						</div>

						<div class="col">
							<h3><?php esc_html_e( 'Any question about this theme or us?', 'eggnews' ); ?></h3>
							<p><?php esc_html_e( 'Please send it via our sales contact page.', 'eggnews' ) ?></p>
							<p><a href="<?php echo esc_url( 'http://themeegg.com/contact/' ); ?>"
							      class="button button-secondary"><?php esc_html_e( 'Contact Page', 'eggnews' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3>
								<?php
								esc_html_e( 'Translate', 'eggnews' );
								echo ' ' . $theme->display( 'Name' );
								?>
							</h3>
							<p><?php esc_html_e( 'Click below to translate this theme into your own language.', 'eggnews' ) ?></p>
							<p>
								<a href="<?php echo esc_url( 'https://translate.wordpress.org/projects/wp-themes/eggnews' ); ?>"
								   class="button button-secondary">
									<?php
									esc_html_e( 'Translate', 'eggnews' );
									echo ' ' . $theme->display( 'Name' );
									?>
								</a>
							</p>
						</div>
					</div>
				</div>

				<div class="return-to-dashboard eggnews">
					<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
						<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
							<?php is_multisite() ? esc_html_e( 'Return to Updates', 'eggnews' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'eggnews' ); ?>
						</a> |
					<?php endif; ?>
					<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'eggnews' ) : esc_html_e( 'Go to Dashboard', 'eggnews' ); ?></a>
				</div>
			</div>
			<?php
		}

		/**
		 * Output the changelog screen.
		 */
		public function changelog_screen() {
			global $wp_filesystem;

			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<p class="about-description"><?php esc_html_e( 'View changelog below:', 'eggnews' ); ?></p>

				<?php
				$changelog_file = apply_filters( 'eggnews_changelog_file', get_template_directory() . '/readme.txt' );

				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog      = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = $this->parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
				?>
			</div>
			<?php
		}

		/**
		 * Output the changelog screen.
		 */
		public function freevspro_screen() {
			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<p class="about-description"><?php esc_html_e( 'Upgrade to PRO version for more awesome features.', 'eggnews' ); ?></p>

				<table>
					<thead>
					<tr>
						<th class="table-feature-title"><h3><?php esc_html_e( 'Features', 'eggnews' ); ?></h3></th>
						<th><h3><?php esc_html_e( 'Egggnews', 'eggnews' ); ?></h3></th>
						<th><h3><?php esc_html_e( 'Eggnews Pro', 'eggnews' ); ?></h3></th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td><h3><?php esc_html_e( 'Support', 'eggnews' ); ?></h3></td>
						<td><?php esc_html_e( 'Forum', 'eggnews' ); ?></td>
						<td><?php esc_html_e( 'Forum + Emails/Support Ticket', 'eggnews' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Category color options', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Additional color options', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><?php esc_html_e( '15', 'eggnews' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Primary color option', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Font size options', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Google fonts options', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><?php esc_html_e( '500+', 'eggnews' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Custom widgets', 'eggnews' ); ?></h3></td>
						<td><?php esc_html_e( '7', 'eggnews' ); ?></td>
						<td><?php esc_html_e( '16', 'eggnews' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Social icons', 'eggnews' ); ?></h3></td>
						<td><?php esc_html_e( '6', 'eggnews' ); ?></td>
						<td><?php esc_html_e( '6', 'eggnews' ); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Social sharing', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Site layout option', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Options in breaking news', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Change read more text', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Related posts', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Author biography', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Footer copyright editor', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( '728x90 Advertisement', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Featured category slider', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Random posts widget', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Tabbed widget', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Videos', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>

					<tr>
						<td><h3><?php esc_html_e( 'WooCommerce compatible', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Multiple header options', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Readmore flying card', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Weather widget', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Currency converter widget', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Category enable/disable option', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Reading indicator option', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Lightbox support', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Call to action widget', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e( 'Contact us template', 'eggnews' ); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td class="btn-wrapper">
							<a href="<?php echo esc_url( apply_filters( 'eggnews_pro_theme_url', 'https://themeegg.com/downloads/eggnews-pro-wordpress-theme/' ) ); ?>"
							   class="button button-secondary docs"
							   target="_blank"><?php esc_html_e( 'View Pro', 'eggnews' ); ?></a>
						</td>
					</tr>
					</tbody>
				</table>

			</div>
			<?php
		}

		/**
		 * Parse changelog from readme file.
		 *
		 * @param  string $content
		 *
		 * @return string
		 */
		private function parse_changelog( $content ) {
			$matches   = null;
			$regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
			$changelog = '';

			if ( preg_match( $regexp, $content, $matches ) ) {
				$changes = explode( '\r\n', trim( $matches[1] ) );

				$changelog .= '<pre class="changelog">';

				foreach ( $changes as $index => $line ) {
					$changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
				}

				$changelog .= '</pre>';
			}

			return wp_kses_post( $changelog );
		}


		/**
		 * Output the supported plugins screen.
		 */
		public function supported_plugins_screen() {
			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<p class="about-description"><?php esc_html_e( 'This theme recommends following plugins:', 'eggnews' ); ?></p>
				<ol>
					<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/social-icons/' ); ?>"
					       target="_blank"><?php esc_html_e( 'Social Icons', 'eggnews' ); ?></a>
						<?php esc_html_e( ' by ThemeEgg', 'eggnews' ); ?>
					</li>
					<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/easy-social-sharing/' ); ?>"
					       target="_blank"><?php esc_html_e( 'Easy Social Sharing', 'eggnews' ); ?></a>
						<?php esc_html_e( ' by ThemeEgg', 'eggnews' ); ?>
					</li>
					<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/contact-form-7/' ); ?>"
					       target="_blank"><?php esc_html_e( 'Contact Form 7', 'eggnews' ); ?></a></li>
					<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/wp-pagenavi/' ); ?>"
					       target="_blank"><?php esc_html_e( 'WP-PageNavi', 'eggnews' ); ?></a></li>
					<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/woocommerce/' ); ?>"
					       target="_blank"><?php esc_html_e( 'WooCommerce', 'eggnews' ); ?></a></li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/polylang/' ); ?>"
						   target="_blank"><?php esc_html_e( 'Polylang', 'eggnews' ); ?></a>
						<?php esc_html_e( 'Fully Compatible in Pro Version', 'eggnews' ); ?>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wpml.org/' ); ?>"
						   target="_blank"><?php esc_html_e( 'WPML', 'eggnews' ); ?></a>
						<?php esc_html_e( 'Fully Compatible in Pro Version', 'eggnews' ); ?>
					</li>
				</ol>

			</div>
			<?php
		}

	}

endif;

return new EggNews_Admin();
