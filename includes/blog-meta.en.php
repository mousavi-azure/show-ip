<?php
/**
 * Blog article metadata (English) — single source of truth for the listing
 * page, sitemap generation, and each article's own meta tags / JSON-LD.
 * Order here is display order on the listing page.
 * @return array<string,array{title:string,description:string,excerpt:string,date:string}>
 */
return [
    'whats-my-ip-iran' => [
        'title' => 'What Is My IP? Reading Your IP Address Lookup',
        'description' => 'See your current IP address and understand every part of the result: country, city, ISP, ASN, and why the location is sometimes wrong (CGNAT, mobile carriers, VPNs).',
        'excerpt' => 'Open your "what is my IP" result and learn what each line — from ISP to CGNAT — actually means.',
        'date' => '2026-09-03',
        'keywords' => 'what is my ip, my ip address, check my ip, ip lookup, ip address location',
        'section' => 'IP Basics',
    ],
    'get-static-ip-iran' => [
        'title' => 'How to Get a Static (Public) IP From Your ISP',
        'description' => 'A practical guide to getting a static, publicly reachable IP address from your ISP for CCTV, remote desktop and self-hosted servers — plus how static, public and NAT differ.',
        'excerpt' => 'Need to reach a camera or PC from outside your network? Here is how a static IP actually works.',
        'date' => '2026-09-03',
        'modified' => '2026-09-03',
        'keywords' => 'static ip, public ip, get a static ip, static ip for cctv, port forwarding, CGNAT',
        'section' => 'IP Basics',
        'howto' => [
            'name' => 'Get a static public IP address from your ISP',
            'totalTime' => 'PT10M',
            'steps' => [
                ['name' => 'Check your current IP type', 'text' => 'Open Show-IP.ir and compare the public IP shown with your router WAN IP. If they differ, you are behind carrier NAT (CGNAT).'],
                ['name' => 'Contact your ISP', 'text' => 'Ask your provider for a "static IP" or "valid/public IP" add-on for your line.'],
                ['name' => 'Pick the right plan', 'text' => 'Static IPs are usually sold monthly on DSL/fibre lines; on mobile data they are often only available on business plans.'],
                ['name' => 'Configure the router and port forwarding', 'text' => 'Once the static IP is active, forward the ports you need (e.g. 80/443 or your DVR port) to the target device in the router panel.'],
                ['name' => 'Test from outside the network', 'text' => 'Using mobile data (not the same Wi-Fi), open the static IP to confirm it is reachable from the internet.'],
            ],
        ],
    ],
    'reduce-ping-online-games' => [
        'title' => 'How to Reduce Ping in Online Games',
        'description' => 'What ping is, why it spikes, and how to lower it with a wired connection, the right server region, a clean network path and — when it helps — a low-latency VPN.',
        'excerpt' => 'High ping is not only your internet speed — the route your packets take to the game server matters too.',
        'date' => '2026-09-03',
        'keywords' => 'reduce ping, high ping, lower ping, fix lag, ping in games, best dns for gaming',
        'section' => 'Networking & Gaming',
    ],
    'check-ip-blacklist' => [
        'title' => 'How to Check if Your IP Is Blacklisted (and Fix It)',
        'description' => 'If sites will not load, your email lands in spam, or you keep seeing CAPTCHAs, your IP address may be blacklisted. How to check IP reputation and get off blocklists.',
        'excerpt' => 'Why some sites block your IP address, and how to tell whether the problem is really your IP.',
        'date' => '2026-09-03',
        'keywords' => 'ip blacklist, check ip blacklist, ip reputation, blocked ip, ip on blocklist, dnsbl',
        'section' => 'Security & Privacy',
    ],
    'what-is-an-ip-address' => [
        'title' => 'What Is an IP Address? A Complete, Simple Guide',
        'description' => 'What an IP address is, how it works, and why every device on the internet needs one — explained simply with examples.',
        'excerpt' => "The numeric label every device on the internet is identified by, explained simply.",
        'date' => '2026-07-24',
    ],
    'ipv4-vs-ipv6' => [
        'title' => 'IPv4 vs IPv6: What\'s the Difference?',
        'description' => 'IPv4 vs IPv6 compared: address structure, how many addresses each allows, why the internet is migrating, and which one you\'re using.',
        'excerpt' => "Why the internet is moving from IPv4 to IPv6, and what actually changes.",
        'date' => '2026-07-24',
    ],
    'how-vpn-changes-your-ip' => [
        'title' => 'How a VPN Changes Your IP Address',
        'description' => 'How a VPN hides your real IP address, how it differs from a proxy, and how services detect that an IP belongs to a VPN.',
        'excerpt' => "What actually happens to your IP address the moment you turn a VPN on.",
        'date' => '2026-07-24',
    ],
    'static-vs-dynamic-ip' => [
        'title' => 'Static vs Dynamic IP: What\'s the Difference?',
        'description' => 'The difference between static and dynamic IP addresses, the pros and cons of each, and which one fits which use case.',
        'excerpt' => "Why your home IP keeps changing, while some servers keep the same one forever.",
        'date' => '2026-07-24',
    ],
    'private-vs-public-ip' => [
        'title' => 'Private vs Public IP Addresses Explained',
        'description' => 'The difference between private and public IP addresses, the standard private IP ranges, and how NAT lets many devices share one public IP.',
        'excerpt' => "Why the IP shown in your router settings doesn't match the IP this site sees.",
        'date' => '2026-07-24',
    ],
    'how-to-hide-your-ip' => [
        'title' => 'How to Hide Your IP Address',
        'description' => 'Real ways to hide your IP address — VPN, Tor, and proxies — with the pros, cons, and privacy trade-offs of each.',
        'excerpt' => "A few real, practical ways to mask your IP address while browsing.",
        'date' => '2026-07-24',
    ],
    'find-ip-address-windows' => [
        'title' => 'How to Find Your IP Address on Windows',
        'description' => 'Step-by-step guide to finding your local and public IP address on Windows 10 and 11, via Settings and the command line.',
        'excerpt' => "The fastest ways to see your local and public IP on a Windows PC.",
        'date' => '2026-07-24',
    ],
    'find-ip-address-linux' => [
        'title' => 'How to Find Your IP Address on Linux',
        'description' => 'Using the ip, hostname, and ifconfig commands to find your local and public IP address across Linux distributions.',
        'excerpt' => "Terminal commands to quickly check your local and public IP on Linux.",
        'date' => '2026-07-24',
    ],
    'find-ip-address-mac' => [
        'title' => 'How to Find Your IP Address on Mac',
        'description' => 'How to find your local and public IP address on macOS through System Settings and the Terminal.',
        'excerpt' => "Ways to check your local and public IP on a Mac, from Settings or the Terminal.",
        'date' => '2026-07-24',
    ],
    'find-ip-address-android' => [
        'title' => 'How to Find Your IP Address on Android',
        'description' => 'How to find your Wi-Fi local IP address and your public IP address on an Android phone via Settings.',
        'excerpt' => "Simple steps to see your Wi-Fi and public IP on an Android phone.",
        'date' => '2026-07-24',
    ],
    'find-ip-address-iphone' => [
        'title' => 'How to Find Your IP Address on iPhone',
        'description' => 'How to find your Wi-Fi local IP address and your public IP address on an iPhone via Settings.',
        'excerpt' => "The exact path in iPhone Settings to see your Wi-Fi and public IP.",
        'date' => '2026-07-24',
    ],
];
