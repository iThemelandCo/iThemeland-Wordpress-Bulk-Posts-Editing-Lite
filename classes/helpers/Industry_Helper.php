<?php

namespace wpbel\classes\helpers;

class Industry_Helper
{
    public static function get_industries()
    {
        return [
            'Automotive and Transportation' => esc_html__('Automotive', WPBEL_NAME),
            'AdTech and AdNetwork' => esc_html__('AdTech and AdNetwork', WPBEL_NAME),
            'Agency' => esc_html__('Agency', WPBEL_NAME),
            'B2B Software' => esc_html__('B2B Software', WPBEL_NAME),
            'B2C Internet Services' => esc_html__('B2C Internet Services', WPBEL_NAME),
            'Classifieds' => esc_html__('Classifieds', WPBEL_NAME),
            'Consulting and Market Research' => esc_html__('Consulting and Market Research', WPBEL_NAME),
            'CPG, Food and Beverages' => esc_html__('CPG', WPBEL_NAME),
            'Education' => esc_html__('Education', WPBEL_NAME),
            'Education (student)' => esc_html__('Education (Student)', WPBEL_NAME),
            'Equity Research' => esc_html__('Equity Research', WPBEL_NAME),
            'Financial services' => esc_html__('Financial Services', WPBEL_NAME),
            'Gambling / Gaming' => esc_html__('Gambling and Gaming', WPBEL_NAME),
            'Hedge Funds and Asset Management' => esc_html__('Hedge Funds and Asset Management', WPBEL_NAME),
            'Investment Banking' => esc_html__('Investment Banking', WPBEL_NAME),
            'Logistics and Shipping' => esc_html__('Logistics and Shipping', WPBEL_NAME),
            'Payments' => esc_html__('Payments', WPBEL_NAME),
            'Pharma and Healthcare' => esc_html__('Pharma and Healthcare', WPBEL_NAME),
            'Private Equity and Venture Capital' => esc_html__('Private Equity and Venture Capital', WPBEL_NAME),
            'Media and Entertainment' => esc_html__('Publishers and Media', WPBEL_NAME),
            'Government Public Sector & Non Profit' => esc_html__('Public Sector, Non Profit, Fraud and Compliance', WPBEL_NAME),
            'Retail / eCommerce' => esc_html__('Retail and eCommerce', WPBEL_NAME),
            'Telecom and Hardware' => esc_html__('Telecom', WPBEL_NAME),
            'Travel and Hospitality' => esc_html__('Travel', WPBEL_NAME),
            'Other' => esc_html__('Other', WPBEL_NAME),
        ];
    }
}
