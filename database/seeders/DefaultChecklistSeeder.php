<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DefaultChecklistSeeder extends Seeder
{
    public static function getDefaultTasks(): array
    {
        return [
             ['category' => 'Website Development', 'task' => 'Finalize & Gather client needs'],
            ['category' => 'Website Development', 'task' => 'Secure website domain & hosting'],
            ['category' => 'Website Development', 'task' => 'During onboarding meeting, clarify the services they want on the website (if SEO team did not clarify)'],
            ['category' => 'Website Development', 'task' => 'During onboarding meeting, ask for USP (if PPC team did not clarify)'],
            ['category' => 'Website Development', 'task' => 'Design base pages'],
            ['category' => 'Website Development', 'task' => 'Design approval from client'],
            ['category' => 'Website Development', 'task' => 'Prepare staging site for development'],

            ['category' => 'Install necessary plugins and themes', 'task' => 'Install latest WordPress version'],
            ['category' => 'Install necessary plugins and themes', 'task' => 'Install TCJ Blank Hello Elementor Theme and Child theme'],
            ['category' => 'Install necessary plugins and themes', 'task' => 'Install Elementor plugin and Elementor pro plugin'],
            ['category' => 'Install necessary plugins and themes', 'task' => 'Activate Elementor pro plugin'],
            ['category' => 'Install necessary plugins and themes', 'task' => 'Develop web pages based on design'],
            ['category' => 'Install necessary plugins and themes', 'task' => 'Disable auto updates for Elementor & WPRocket'],
            ['category' => 'Install necessary plugins and themes', 'task' => 'Coordinate with Content writers to finilaze web page contents'],
            ['category' => 'Install necessary plugins and themes', 'task' => 'Final checking with client for site launch'],

            ['category' => 'Launch new website', 'task' => 'Install SG Security plugin (Install WP Activity Log if not hosted in Siteground)'],
            ['category' => 'Launch new website', 'task' => 'Install WP Rocket plugin'],
            ['category' => 'Launch new website', 'task' => 'Install Imagify plugin'],
            ['category' => 'Launch new website', 'task' => 'Configure WP Rocket plugin through importing pre-made settings'],
            ['category' => 'Launch new website', 'task' => 'Install RankMath SEO plugin'],
            ['category' => 'Launch new website', 'task' => 'Install Call now Button plugin'],
            ['category' => 'Launch new website', 'task' => 'Add new GSC as Domain property, install the TXT code via Hosting, & verify it.'],
            ['category' => 'Launch new website', 'task' => 'Add new GTM account & install GTM codes via Elementor Custom Code'],
            ['category' => 'Launch new website', 'task' => 'Add new Google Analytics account & install the code.'],
            ['category' => 'Launch new website', 'task' => 'Install UTM code via Elementor Custom code (for GBP submissions tracking)'],
            ['category' => 'Launch new website', 'task' => 'Install Google Recaptcha'],
            ['category' => 'Launch new website', 'task' => 'Improve page speed via WP Rocket and Imagify'],
            ['category' => 'Launch new website', 'task' => 'Disable auto description meta tag create via Theme Settings'],
            ['category' => 'Launch new website', 'task' => 'Contact forms should use WPForms forms (case-to-case)'],
            ['category' => 'Launch new website', 'task' => 'Every contact form should have Referrer URL'],
            ['category' => 'Launch new website', 'task' => 'Form fields should be set to required'],
            ['category' => 'Launch new website', 'task' => 'Form Email Subject Line should follow correct format'],
            ['category' => 'Launch new website', 'task' => 'Form Reply-to setting should be set to Email Field'],
            ['category' => 'Launch new website', 'task' => 'From Name should be set to Company Name'],
            ['category' => 'Launch new website', 'task' => 'From Email-from should be set to no-reply@domain.com'],
            ['category' => 'Launch new website', 'task' => 'Contact forms should redirect to Thank You page after sending'],
            ['category' => 'Launch new website', 'task' => 'Make sure the forms are working'],
            ['category' => 'Launch new website', 'task' => 'Verify email recipient for contact form and CC tcjleads@gmail.com'],
            ['category' => 'Launch new website', 'task' => 'Make sure page title / main page heading is using H1 tag'],
            ['category' => 'Launch new website', 'task' => 'Coordinate with the Google Ads team for exact phone number'],
            ['category' => 'Launch new website', 'task' => 'Make sure all numbers are clickable for direct call'],
            ['category' => 'Launch new website', 'task' => 'Make sure site is optimized on mobile'],
            ['category' => 'Launch new website', 'task' => 'Make sure to have privacy policy and terms pages'],
            ['category' => 'Launch new website', 'task' => 'Designate the Page as Your Privacy Policy in WordPress Settings'],
            ['category' => 'Launch new website', 'task' => 'Make sure images have alt tags'],
            ['category' => 'Launch new website', 'task' => 'Add an OpenGraph thumbnail via Rank Math'],
            ['category' => 'Launch new website', 'task' => 'Add blog page if there’s none existing'],
            ['category' => 'Launch new website', 'task' => 'Only show blog page if there are at least 2 blog posts'],
            ['category' => 'Launch new website', 'task' => 'Blog URLs should be /blog/[blog-name]'],
            ['category' => 'Launch new website', 'task' => 'Blog author name should be Client’s name'],
            ['category' => 'Launch new website', 'task' => 'Create account for blog writers (Editor role / writer@topclickjoe.com / writer / MOBdg!@os3stP&8TNfZpk!9k)'],
            ['category' => 'Launch new website', 'task' => 'Create account for pillar writers (Editor role / pillar@topclickjoe.com / pillar / FCwIaDH4$GpDW0gy(i75Qa!Q)'],
            ['category' => 'Launch new website', 'task' => 'Create account for SEO users (Editor role / seo@topclickjoe.com / tcjseo / T6Kxq132(CwUnENCow#v0QEn)'],
            ['category' => 'Launch new website', 'task' => 'Call Now buttons should be numbers for tracking'],
            ['category' => 'Launch new website', 'task' => 'Numbers should be very visible'],
            ['category' => 'Launch new website', 'task' => 'Perform #google-wcc-debug to double check on the numbers'],
            ['category' => 'Launch new website', 'task' => 'If site is cloned, use Better Search & Replace plugin'],
            ['category' => 'Launch new website', 'task' => 'Install Hotjar tracking'],
            ['category' => 'Launch new website', 'task' => 'Coordinate with PPC team on what landing page to create'],
            ['category' => 'Launch new website', 'task' => 'URL of landing pages should be /ppc/[service-url]'],
            ['category' => 'Launch new website', 'task' => 'Make sure PPC pages has noindex/nofollow tag'],
            ['category' => 'Launch new website', 'task' => 'Link review badge to testimonial section'],
            ['category' => 'Launch new website', 'task' => 'Remove select service on PPC forms'],
            ['category' => 'Launch new website', 'task' => 'PPC landing pages should have no outgoing links'],
            ['category' => 'Launch new website', 'task' => 'Add Honeypot field for PPC landing pages'],
            ['category' => 'Launch new website', 'task' => 'Install Honeypot code via Elementor'],
            ['category' => 'Launch new website', 'task' => 'Service page form titles should match service'],
            ['category' => 'Launch new website', 'task' => 'SEO/front pages should have appealing headlines'],
            ['category' => 'Launch new website', 'task' => 'Send PPC landing page URLs to PPC team'],
            ['category' => 'Launch new website', 'task' => 'Add sitemap page and footer menu item'],
            ['category' => 'Launch new website', 'task' => 'Service pages URL structure should be /services/[service-name]'],
            ['category' => 'Launch new website', 'task' => 'Add Resources page for pillar pages'],
            ['category' => 'Launch new website', 'task' => 'Enable Excerpt for pages'],
            ['category' => 'Launch new website', 'task' => 'Pillar page URL structure should be /resources/[pillar-page-title]'],
            ['category' => 'Launch new website', 'task' => 'Block all countries except PH and client country'],
            ['category' => 'Launch new website', 'task' => 'Add 404 page template'],
            ['category' => 'Launch new website', 'task' => 'Uncheck Discourage search engines from indexing this site']
        ];
    }

    public function run(): void
    {
        // Left empty intentionally
    }
}