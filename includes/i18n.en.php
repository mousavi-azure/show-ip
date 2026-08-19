<?php
/**
 * English translations.
 * @return array<string,string>
 */
return [
    // --- SEO / meta ---
    "Home Meta Title" => "What Is My IP Address? Location & Network Lookup",
    "Home Meta Description" => "Find your public IP address along with your country, city, ISP, time zone and location on a map. Includes VPN/proxy/Tor detection and a free subnet calculator.",
    "Home Meta Keywords" => "what is my ip, my ip address, ip lookup, ip location, ip address lookup, subnet calculator, cidr calculator, vpn detection, proxy detection, show-ip.ir",
    "FAQ Meta Title" => "Frequently Asked Questions about IP & Networking",
    "FAQ Meta Description" => "Answers to common questions about IP addresses, privacy, VPN/proxy detection, location accuracy and the subnet calculator on Show-IP.ir.",
    "Blog Meta Title" => "IP & Networking Articles",
    "Blog Meta Description" => "A collection of educational articles about IP addresses, IPv4 vs IPv6, VPNs, static vs dynamic and private vs public IPs, and guides to finding your IP on Windows, Mac, Linux, Android and iPhone.",
    "Home" => "Home",

    // --- Header ---
    "Brand Subtitle" => "IP Lookup & Network Tools",
    "Logo Alt" => "%s logo",
    "Guide" => "Guide",
    "Show My IP Nav" => "Show My IP",

    // --- Hero ---
    "Site Status Live" => "Live",
    "Hero Heading" => "What Is My IP?",
    "IP Details Lookup" => "IP Details Lookup",

    // --- Errors / notes ---
    "Error Label" => "Error",
    "Env Key Missing Note" => "The API key is not configured in the %s file.",
    "Note" => "Note",
    "Service temporarily unavailable" => "Service temporarily unavailable",

    // --- IP badge ---
    "IP Section Aria" => "Your public IP address",
    "Your public IP address" => "Your public IP address",
    "Copy" => "Copy",

    // --- Location card ---
    "Location Information" => "Location",
    "Country" => "Country",
    "Region" => "Region",
    "City" => "City",
    "Postal Code" => "Postal Code",
    "Coordinates" => "Coordinates",
    "Continent" => "Continent",
    "Calling Code" => "Calling Code",

    // --- Map / geolocation ---
    "Map Alt" => "World map (self-hosted)",
    "Use my precise location" => "Use my precise location",
    "IP-based location" => "IP-based location",
    "Your precise location" => "Your precise location",
    "Open in OpenStreetMap" => "Open in OpenStreetMap",
    "Map is self-hosted; nothing is loaded from external map servers. Precise location uses your browser only and is never sent anywhere." =>
        "The map is hosted locally on this server — nothing is loaded from an external map service. Your precise location is calculated in your browser only and is never sent anywhere.",
    "Geolocation Not Supported" => "Your browser doesn't support geolocation",
    "Locating" => "Locating your precise position…",
    "Accuracy Message" => "Accuracy: about %s meters",
    "Permission Denied" => "Location permission was denied.",
    "Position Unavailable" => "Location is unavailable.",
    "Position Timeout" => "Timed out while locating you.",
    "Location Error" => "Couldn't determine your location.",
    "Precise Location Title" => "Your precise location (± %s m)",

    // --- Network card ---
    "Network Information" => "Network",
    "ISP" => "ISP",
    "ASN" => "ASN",
    "Organization" => "Organization",
    "Route" => "Route",
    "Connection Type" => "Connection Type",
    "Time Zone" => "Time Zone",
    "Local Time" => "Local Time",
    "Currency" => "Currency",
    "Language" => "Language",
    "Carrier" => "Carrier",

    // --- Threat ---
    "Threat Information" => "Security Check",
    "Security Status" => "Security Status",
    "Clean" => "Clean",
    "Flagged" => "Flagged",
    "Is Tor" => "Tor Network",
    "Is Proxy" => "Proxy",
    "Is VPN / Datacenter" => "VPN / Datacenter",
    "Is iCloud Relay" => "iCloud Private Relay",
    "Is Anonymous" => "Anonymous",
    "Is Known Attacker" => "Known Attacker",
    "Is Known Abuser" => "Known Abuser",
    "Is Threat" => "Known Threat",
    "Is Tor Desc" => "This IP belongs to the Tor network, used for anonymous browsing.",
    "Is Proxy Desc" => "This IP is connecting through a proxy server.",
    "Is VPN / Datacenter Desc" => "This IP belongs to a datacenter or VPN service, not a typical home connection.",
    "Is iCloud Relay Desc" => "This IP passed through Apple's iCloud Private Relay service.",
    "Is Anonymous Desc" => "This connection was identified as anonymized via VPN, proxy or Tor.",
    "Is Known Attacker Desc" => "This IP has previously been seen in known cyberattacks.",
    "Is Known Abuser Desc" => "This IP has been reported on abuse lists (e.g. spam).",
    "Is Threat Desc" => "This IP is generally recognized as a security threat source.",
    "Security Summary Clean" => "Based on %d security checks, this IP shows no signs of VPN, proxy, Tor or malicious activity.",
    "Security Summary Flagged" => "This IP was flagged in %d of %d security checks — see details below.",
    "Raw API Response" => "Raw API Response",
    "Yes" => "Yes",
    "No" => "No",
    "N/A" => "N/A",

    // --- Calculator ---
    "Network Calculator" => "Subnet Calculator",
    "Calculator Section Aria" => "Subnet calculator",
    "Calculate" => "Calculate",
    "IP Address" => "IP Address",
    "Subnet Mask or CIDR" => "Subnet Mask or CIDR",
    "IP Placeholder" => "e.g. 192.168.1.10",
    "Subnet Placeholder" => "e.g. 255.255.255.0 or /24",
    "Calculating" => "Calculating",
    "Calc Missing Fields" => "Please enter both an IP address and a subnet mask or CIDR.",
    "Calc Generic Error" => "Something went wrong.",
    "Calc Invalid Response" => "Invalid response from server.",
    "Calc Network Address" => "Network Address",
    "Calc Broadcast Address" => "Broadcast Address",
    "Calc First Usable" => "First Usable Host",
    "Calc Last Usable" => "Last Usable Host",
    "Calc Subnet Mask" => "Subnet Mask",
    "Calc CIDR" => "CIDR",
    "Calc Total Addresses" => "Total Addresses",
    "Calc Usable Hosts" => "Usable Hosts",
    "Calc Host Bits" => "Host Bits",

    // --- CLI ---
    "CLI Aria" => "Terminal usage",
    "CLI Heading" => "Get your IP from the terminal (CLI)",
    "CLI Description" => "Just like %s, you can get your server or system's public IP straight from the command line — no browser needed. Great for scripts and Linux servers.",
    "CLI Desc Plain" => "Your IP as plain text",
    "CLI Desc IP" => "IP only (also works in a browser)",
    "CLI Desc JSON" => "Full details as JSON",

    // --- FAQ ---
    "Frequently Asked Questions" => "Frequently Asked Questions",
    "FAQ Section Aria" => "Frequently asked questions",
    "FAQ Teaser Subtitle" => "Everything you need to know about your IP, location and connection security",
    "View All FAQ" => "See all questions on the guide page",
    "Back To Home CTA" => "Back to my IP",

    // --- Blog ---
    "Blog" => "Articles",
    "Blog Section Aria" => "Educational articles",
    "All Articles" => "All Articles",
    "Blog Intro" => "Clear, accurate guides on IP addresses, networking, VPNs and privacy — without unnecessary technical jargon.",
    "Read Article" => "Read article",
    "Published" => "Published",
    "Back to Articles" => "Back to articles",
    "Article Not Found" => "Article not found",
    "Article Not Found Body" => "The link may be wrong, or the article may have moved.",
    "Try The Tool" => "Try it",
    "Related Articles" => "Related articles",

    // --- Footer ---
    "Footer Credit Prefix" => "Crafted with",
    "Footer Credit Suffix" => "by",
    "All Rights Reserved" => "All rights reserved.",

    // --- Misc UI ---
    "Tools & Calculator" => "Tools & Calculator",
    "Toggle theme" => "Toggle light/dark theme",
    "Copied" => "Copied!",
    "IP Copied" => "IP address copied!",
];
