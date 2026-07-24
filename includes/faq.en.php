<?php
/**
 * FAQ content (English). Used both for the visible accordion and the
 * schema.org FAQPage structured data — single source of truth for SEO.
 * @return array<int,array{q:string,a:string}>
 */
return [
    [
        'q' => 'What is my IP address, and how does this site show it?',
        'a' => 'An IP address is a unique numeric identifier assigned to your device by your internet service provider (ISP). Show-IP.ir displays the public IP address your device is using to connect to the internet, along with its country, city, ISP and an approximate location on the map.',
    ],
    [
        'q' => 'Is showing my IP address and location a privacy risk?',
        'a' => "No. Every website you visit already sees this same public IP address — it isn't secret information. The location shown is only approximate, at city level, and does not reveal your exact home address. Show-IP.ir does not store any of your information.",
    ],
    [
        'q' => "Why does the city or location shown not match my real location?",
        'a' => "Location is estimated from your ISP's IP address database, not from GPS. On mobile networks and with some ISPs, an IP address may be registered to a regional hub or a different city, so a difference of a few kilometers — or even a different city — is normal.",
    ],
    [
        'q' => 'How does VPN, proxy and Tor detection work?',
        'a' => 'The "Security Check" section shows whether your IP address belongs to the Tor network, a proxy, a datacenter/VPN, or a known blocklist. This is useful for checking connection anonymity and spotting suspicious traffic.',
    ],
    [
        'q' => 'What does the subnet calculator do?',
        'a' => 'Enter an IPv4 address and a subnet mask or CIDR (like /24) to instantly calculate the network address, broadcast address, first and last usable host, total address count, and usable host count. A handy tool for network admins and students.',
    ],
    [
        'q' => 'Is Show-IP.ir free to use?',
        'a' => 'Yes, every feature on this site — IP lookup, network information, the security check and the subnet calculator — is completely free, with no sign-up required.',
    ],
    [
        'q' => "How does the map work, and is my precise location stored anywhere?",
        'a' => "The world map is fully self-hosted on this server — no requests are ever sent to external map services (like OpenStreetMap), so it keeps working even during outages or filtering. The \"Use my precise location\" button uses your browser's geolocation with your permission; those coordinates are only shown on the map in your browser at that moment and are never sent to or stored on any server.",
    ],
];
