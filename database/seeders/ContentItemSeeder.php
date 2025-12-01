<?php

namespace Database\Seeders;

use App\Jobs\AutoTranslateContentItem;
use App\Models\Category;
use App\Models\ContentItem;
use App\Models\Currency;
use App\Services\MachineTranslation\MachineTranslationService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ContentItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contentData = [
            'quantum' => [
                [
                    'title' => 'Post-Quantum Cryptography (PQC) Stack',
                    'description' => 'Deploy NIST-standardized, lattice-based cryptographic algorithms for modern architectures. PQC engine empowers your platforms to transition from RSA/ECC to quantum-resistant encryption, signatures, and key encapsulation.',
                    'category' => null,
                    'date' => '2025-05-01',
                    'objective_list' => [
                        'Support for NIST finalist algorithms (CRYSTALS-Kyber, Dilithium, etc.)',
                        'Drop-in API replacement for TLS, VPNs, and secure boot',
                        'Chip-compatible with QHSM, IDPS, and OTA modules',
                        'Lattice-based and hash-based cryptographic primitives',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Quantum-as-a-Service (QaaS)',
                    'description' => 'On-demand quantum security modules through a secure developer-friendly cloud so startups, OEMs, and Tier-1s can adopt quantum security without upfront hardware investments.',
                    'category' => null,
                    'date' => '2025-05-05',
                    'objective_list' => [
                        'API-first access to QRNG, PQC signing, secure boot, and OTA validation',
                        'Cloud-hosted simulation for QKD session initiation',
                        'Tiered plans for automotive, industrial, and defense workloads',
                        'Compliance-ready logs and attestation with SBOM/CBOM linkage',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Quantum Random Number Generator (QRNG)',
                    'description' => 'Generate unbreakable cryptographic keys with quantum-grade randomness using hardware-sourced entropy for embedded, cloud, and edge environments.',
                    'category' => null,
                    'date' => '2025-05-09',
                    'objective_list' => [
                        'Hardware-based quantum randomness (non-deterministic)',
                        'Continuous entropy validation and health checks',
                        'Seamless integration with QHSM and PQC modules',
                        'Scalable across embedded chips, edge devices, and cloud',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Quantum Hardware Security Module (QHSM)',
                    'description' => 'Secure storage and lifecycle management for cryptographic assets in the post-quantum era with tamper-resistant protection optimized for quantum-secure architectures.',
                    'category' => null,
                    'date' => '2025-05-13',
                    'objective_list' => [
                        'Secure storage for PQC, symmetric, and hybrid keys',
                        'Root of trust for automotive ECUs and cloud endpoints',
                        'Hardware-integrated access control and key isolation',
                        'Certified tamper detection with secure erase and audit trails',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Quantum Key Distribution (QKD)',
                    'description' => 'Future-proof communication channels with photon-based key exchange that keeps vehicle-to-cloud traffic confidential even against quantum computers.',
                    'category' => null,
                    'date' => '2025-05-17',
                    'objective_list' => [
                        'Photon-based secure channel for symmetric key exchange',
                        'Compatible with classical networks (hybrid cryptography support)',
                        'Vehicle-to-cloud and ECU-to-ECU secure session capability',
                        'Seamless integration with QHSM and QRNG',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Quantum-AI Threat Intelligence',
                    'description' => 'Real-time intelligence module that powers SDV security ecosystems by ingesting telemetry across IDPS, OTA, and SBOM to build post-quantum threat profiles.',
                    'category' => null,
                    'date' => '2025-05-21',
                    'objective_list' => [
                        'AI-driven behavior fingerprinting for SDV components',
                        'Version drift and adversarial anomaly detection',
                        'Federated learning across OEM, cloud, and Tier-1 partners',
                        'Integrates with vSOC and QaaS for adaptive patching recommendations',
                    ],
                    'status' => 'active',
                ],
            ],
            'services' => [
                // Automotive
                [
                    'title' => 'ASPICE',
                    'description' => 'Ensure process maturity and product quality through Automotive SPICE compliance with alignment to ASPICE CL2/CL3 and OEM expectations.',
                    'category' => 'Automotive',
                    'date' => '2025-06-01',
                    'objective_list' => [
                        'ASPICE assessments and gap closure planning',
                        'Process modeling and improvement support',
                        'Integrated compliance with ISO 26262 and ISO 21434',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Cybersecurity Management (ISO/SAE 21434, UNECE R155)',
                    'description' => 'Design and implement comprehensive cybersecurity governance spanning the entire vehicle product lifecycle.',
                    'category' => 'Automotive',
                    'date' => '2025-06-04',
                    'objective_list' => [
                        'CSMS process definition and rollout',
                        'TARA (Threat Analysis & Risk Assessment) operations',
                        'PSIRT setup and compliance monitoring',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Functional Safety (FuSa – ISO 26262, SOTIF)',
                    'description' => 'Implement end-to-end functional safety programs that keep systems safe even when components fail.',
                    'category' => 'Automotive',
                    'date' => '2025-06-07',
                    'objective_list' => [
                        'Safety planning, ASIL decomposition, and FMEA',
                        'Safety concept and technical architecture definition',
                        'FMEDA, FTA, and tool qualification support',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Software Update Management System (SUMS – ISO 24089, UNECE R156)',
                    'description' => 'Securely manage OTA software updates with planning, simulation, and deployment guardrails.',
                    'category' => 'Automotive',
                    'date' => '2025-06-10',
                    'objective_list' => [
                        'SUMS compliance and gap analysis',
                        'Dry-run simulations and rollback strategy',
                        'OTA campaign planning and reporting',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'OT Security (IEC 62443)',
                    'description' => 'Harden industrial and vehicle operations against digital threats using IEC 62443-aligned controls.',
                    'category' => 'Automotive',
                    'date' => '2025-06-13',
                    'objective_list' => [
                        '24/7 real-time threat monitoring',
                        'OT threat modeling and zone-based architecture',
                        'Security controls aligned with IEC 62443',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'AUTOSAR',
                    'description' => 'Standardize ECU software architecture with Autosar configuration, integration, and lifecycle support.',
                    'category' => 'Automotive',
                    'date' => '2025-06-16',
                    'objective_list' => [
                        'Configuration and integration services',
                        'Architecture design and optimization',
                        'Tool chain expertise and automation',
                        'Cross-platform compatibility guidance',
                    ],
                    'status' => 'active',
                ],
                // SDV
                [
                    'title' => 'Apps and Services Engineering',
                    'description' => 'Build infotainment apps, driver-assist tools, and cloud services spanning embedded to backend stacks.',
                    'category' => 'SDV',
                    'date' => '2025-06-20',
                    'objective_list' => [
                        'Customized solutions tailored to brand and customer needs',
                        'Advanced analytics to refine features continuously',
                        'Cross-platform integration across vehicles and ecosystems',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Electrical/Electronic Architecture',
                    'description' => 'Design modern E/E architectures that underpin SDV connectivity, OTA readiness, and advanced features.',
                    'category' => 'SDV',
                    'date' => '2025-06-24',
                    'objective_list' => [
                        'Comprehensive bus, power, and cybersecurity alignment',
                        'Future-ready encryption and secure data management',
                        'Reliability and safety built into every subsystem',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Over-the-Air (OTA)',
                    'description' => 'Deliver secure OTA programs that keep vehicles updated with minimal disruption.',
                    'category' => 'SDV',
                    'date' => '2025-06-28',
                    'objective_list' => [
                        'Secure update protocol with encryption and auth',
                        'Seamless deployment and minimal downtime',
                        'Future-proof architecture adaptable to new standards',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'SDV Cloud',
                    'description' => 'Build cloud infrastructures for real-time data analytics, CI/CD, and scalable SDV backends.',
                    'category' => 'SDV',
                    'date' => '2025-07-02',
                    'objective_list' => [
                        'Scalable compute and storage for connected fleets',
                        'Data security, encryption, and compliance controls',
                        'DevOps integration for rapid updates and features',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'SDV HPC',
                    'description' => 'Leverage high-performance computing for ADAS, analytics, and edge ML workloads.',
                    'category' => 'SDV',
                    'date' => '2025-07-06',
                    'objective_list' => [
                        'Powerful computation for data-intensive processes',
                        'Low-latency architecture for safety-critical loops',
                        'Scalable resources as performance needs grow',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'SDV OPS',
                    'description' => 'Optimize SDV operations with automation, observability, and rapid incident response.',
                    'category' => 'SDV',
                    'date' => '2025-07-10',
                    'objective_list' => [
                        'Automated CI/CD for fast deployment cycles',
                        'Real-time monitoring for performance and security',
                        'Scalable infrastructure for growing fleets',
                    ],
                    'status' => 'active',
                ],
                // Avionics
                [
                    'title' => 'Cybersecurity Management System (CSMS) Implementation',
                    'description' => 'Deploy avionics-ready CSMS programs covering governance, risk, and regulatory alignment.',
                    'category' => 'Avionics',
                    'date' => '2025-07-14',
                    'objective_list' => [
                        'Aligned with DO-326A / ED-202A frameworks',
                        'Incident response planning and lifecycle controls',
                        'Supports FAA/EASA audit preparation',
                        'Integration with existing development and quality systems',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Threat Modeling & Risk Assessment',
                    'description' => 'Identify avionics threats early using industry-standard models that span hardware and software.',
                    'category' => 'Avionics',
                    'date' => '2025-07-18',
                    'objective_list' => [
                        'STRIDE, DREAD, and attack tree methodologies',
                        'Coverage for software and hardware vulnerabilities',
                        'Risk prioritization by system safety impact',
                        'Detailed mitigation plans and documentation',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Secure Software & Firmware Design',
                    'description' => 'Embed security into avionics software and firmware to thwart tampering and unauthorized access.',
                    'category' => 'Avionics',
                    'date' => '2025-07-22',
                    'objective_list' => [
                        'Secure bootloader and memory protection',
                        'Cryptographic module support (FIPS 140-3, HSM)',
                        'Secure coding best practices (MISRA-C, CERT-C)',
                        'Compliance with DO-178C plus security overlays',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Secure Data Communication & Protocol Hardening',
                    'description' => 'Protect aircraft data buses and comms against eavesdropping, spoofing, and unauthorized access.',
                    'category' => 'Avionics',
                    'date' => '2025-07-26',
                    'objective_list' => [
                        'In-transit and at-rest encryption schemes',
                        'Secure key exchange and lifecycle management',
                        'ARINC-653, AFDX, Ethernet protocol hardening',
                        'DO-355 airborne system security compliance',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Penetration Testing & Vulnerability Assessment',
                    'description' => 'Simulate real-world cyberattacks on avionics components and interfaces before deployment.',
                    'category' => 'Avionics',
                    'date' => '2025-07-30',
                    'objective_list' => [
                        'Black, white, and grey box testing models',
                        'ARINC-429, CAN, AFDX/Ethernet interface exercises',
                        'CVSS scoring and exploit-path analysis',
                        'Post-test hardening and remediation guidance',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Supply Chain Cybersecurity Management',
                    'description' => 'Secure avionics supply chains through rigorous vendor oversight and SBOM tracking.',
                    'category' => 'Avionics',
                    'date' => '2025-08-03',
                    'objective_list' => [
                        'Security audits and compliance checks for vendors',
                        'Secure component sourcing and counterfeit avoidance',
                        'SBOM generation, vulnerability tracking, analysis',
                        'Continuous monitoring of supply chain threats',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Secure Software Update & Patch Management',
                    'description' => 'Enable authenticated OTA updates for avionics with full integrity and traceability.',
                    'category' => 'Avionics',
                    'date' => '2025-08-07',
                    'objective_list' => [
                        'Digital-signature verification and chain-of-trust',
                        'Firmware rollback protection and version control',
                        'Secure delivery over wired and wireless links',
                        'Alignment with DO-326A and DO-356A requirements',
                    ],
                    'status' => 'active',
                ],
                // Railways (Cybersecurity & RAMS)
                [
                    'title' => 'Railway Cybersecurity Training & Awareness',
                    'description' => 'Enhance railway teams with tailored cybersecurity programs built on industry standards.',
                    'category' => 'Railways',
                    'date' => '2025-08-11',
                    'objective_list' => [
                        'Covers ISA/IEC 62443, CEN TS 50701, ISO 27001',
                        'Customizable for technical, operational, management staff',
                        'Role-specific simulations with real-world scenarios',
                        'Progressive modules from beginner to expert',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Railway Cybersecurity Consultancy',
                    'description' => 'Develop and implement CSMS programs that protect critical railway assets.',
                    'category' => 'Railways',
                    'date' => '2025-08-15',
                    'objective_list' => [
                        'Cybersecurity maturity assessment and gap analysis',
                        'Risk-based roadmap and governance design',
                        'Supply chain risk management integration',
                        'Incident detection and response planning',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Railway Certification Assistance',
                    'description' => 'Guide railway operators through cybersecurity certification and compliance cycles.',
                    'category' => 'Railways',
                    'date' => '2025-08-19',
                    'objective_list' => [
                        'Support for ISA/IEC 62443 and related standards',
                        'Audit preparation and documentation support',
                        'Coordination with accredited certification bodies',
                        'Continuous improvement and recertification strategies',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Railway Security Testing Services',
                    'description' => 'Identify vulnerabilities across railway systems before adversaries exploit them.',
                    'category' => 'Railways',
                    'date' => '2025-08-23',
                    'objective_list' => [
                        'Penetration testing for railway systems and networks',
                        'Phishing simulations and social engineering exercises',
                        'CVSS-based risk prioritization and scoring',
                        'Remediation planning and hardening recommendations',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'RAMS Training & Awareness',
                    'description' => 'Build safety-first cultures with RAMS programs rooted in rail and industrial standards.',
                    'category' => 'Railways',
                    'date' => '2025-08-27',
                    'objective_list' => [
                        'Based on EN 50126, EN 50128, EN 50129, ISO 13849',
                        'Hazard analysis and SIL workshop facilitation',
                        'Hands-on case studies and practical exercises',
                        'Applicable to engineering and operational teams',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'RAMS Consultancy',
                    'description' => 'Embed RAMS best practices into product, system, and infrastructure lifecycles.',
                    'category' => 'Railways',
                    'date' => '2025-08-31',
                    'objective_list' => [
                        'Comprehensive RAMS planning and strategy',
                        'Safety case development and verification',
                        'FMEA and FTA execution',
                        'Support for safety certification processes',
                    ],
                    'status' => 'active',
                ],
                // Health Care and Medical Devices
                [
                    'title' => 'Medical Device Training & Awareness',
                    'description' => 'Equip healthcare product teams with cybersecurity regulations and best practices.',
                    'category' => 'Health Care and Medical Devices',
                    'date' => '2025-09-04',
                    'objective_list' => [
                        'Compliance with EU-MDR, EU-NIS, ISO 27001',
                        'Frameworks for ISA/IEC 62443, IEC/TR 60601-4-5, AAMI TIR57',
                        'Custom training for medical device environments',
                        'Programs for engineers, compliance, and clinicians',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Medical Device Consultancy Services',
                    'description' => 'Build robust cybersecurity roadmaps covering governance through maintenance.',
                    'category' => 'Health Care and Medical Devices',
                    'date' => '2025-09-08',
                    'objective_list' => [
                        'Cybersecurity governance and policy development',
                        'Risk assessment and threat modeling for devices',
                        'Security controls integrated into design and ops',
                        'Lifecycle management for secure products',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Product, Process & Management System Certification',
                    'description' => 'Demonstrate compliance and security capabilities for medical devices and systems.',
                    'category' => 'Health Care and Medical Devices',
                    'date' => '2025-09-12',
                    'objective_list' => [
                        'ISA/IEC 62443 certification support',
                        'System integration and capability validation',
                        'Development lifecycle and assurance certification',
                        'Security posture documentation for audits',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Medical Device Security Testing',
                    'description' => 'Uncover vulnerabilities in medical devices, hospital systems, and supporting networks.',
                    'category' => 'Health Care and Medical Devices',
                    'date' => '2025-09-16',
                    'objective_list' => [
                        'Penetration testing across devices and hospitals',
                        'Phishing simulations and resilience assessments',
                        'Continuous monitoring and vulnerability scanning',
                        'Remediation reporting for regulators and partners',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Software Development for Medical Devices',
                    'description' => 'Enable secure product innovation with ISO 62304-aligned software development.',
                    'category' => 'Health Care and Medical Devices',
                    'date' => '2025-09-20',
                    'objective_list' => [
                        'ISO 62304 compliant lifecycle management',
                        'Secure coding best practices and reviews',
                        'Consultancy on embedding safety and security',
                    ],
                    'status' => 'active',
                ],
            ],
            'products' => [
                [
                    'title' => 'Intrusion Detection and Prevention System',
                    'description' => 'Proactively secure in-vehicle networks against cyber threats with a multi-layered IDPS built for CAN, Ethernet, and host-based environments.',
                    'category' => 'Automotive',
                    'date' => '2025-06-01',
                    'objective_list' => [
                        'Real-time threat detection and blocking for vehicle communication',
                        'Signature, anomaly, and behavior-based detection models',
                        'Tailored SDV-specific SOA IDPS integration',
                        'Advanced log analysis for proactive forensics',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Automator AI',
                    'description' => 'Accelerate vehicle software delivery and testing by automating diagnostics, function rollout, and ownership experiences.',
                    'category' => 'Automotive',
                    'date' => '2025-06-05',
                    'objective_list' => [
                        'Speeds up CI/CD pipelines for automotive-grade software',
                        'Vehicle lifecycle testing and validation automation',
                        'Full API suite for third-party and in-house toolchains',
                        'Predefined automation policies for instant deployments',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'AI Data Collector',
                    'description' => 'Capture, process, and integrate ECU and sensor data with FIR to power vehicle performance and security analytics.',
                    'category' => 'Automotive',
                    'date' => '2025-06-09',
                    'objective_list' => [
                        'High-volume data capture from ECUs and sensors',
                        'Real-time analytics and anomaly detection',
                        'FIR integration for secure intelligence routing',
                        'Cloud or on-premise deployment options',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Software Bill of Materials',
                    'description' => 'Bring transparency, compliance, and efficiency to your software supply chain via comprehensive SBOM management.',
                    'category' => 'Automotive',
                    'date' => '2025-06-13',
                    'objective_list' => [
                        'SBOM generation and lifecycle management',
                        'Vulnerability management workflows',
                        'Open-source software and vendor tracking',
                        'Governance and compliance reporting',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Vehicle Security Operation Center',
                    'description' => 'Operate a cloud-native command center to monitor, detect, and respond to cyber threats across fleets.',
                    'category' => 'Automotive',
                    'date' => '2025-06-17',
                    'objective_list' => [
                        '24/7 real-time threat monitoring',
                        'Centralized incident response and investigations',
                        'Early warning system for emerging exploits',
                        'Seamless integration with IDPS for auto-remediation',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'OTA Updater',
                    'description' => 'Deliver secure, efficient OTA software updates that reduce downtime and delight customers.',
                    'category' => 'Automotive',
                    'date' => '2025-06-21',
                    'objective_list' => [
                        'Encrypted transfer with secure rollback protections',
                        'Delta updates to minimize bandwidth use',
                        'Real-time update status tracking',
                        'Cross-platform compatibility across ECUs',
                    ],
                    'status' => 'active',
                ],
            ],
            'training' => [
                [
                    'title' => 'Cybersecurity Management - ISO 21434',
                    'description' => 'Prepare teams to design, implement, and audit robust cybersecurity governance across the vehicle lifecycle with TARA, CSMS structure, and compliance-driven development.',
                    'category' => 'Automotive',
                    'date' => '2025-07-01',
                    'objective_list' => [
                        'Overview of UNECE R155, R156, and ISO 21434',
                        'Post-development activities and cybersecurity release processes',
                        'Concept-to-decommission secure-by-design practices',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Functional Safety - ISO 26262',
                    'description' => 'End-to-end safety engineering guidance for embedded systems and ECUs covering ASIL allocation, safety concepts, and tool confidence.',
                    'category' => 'Automotive',
                    'date' => '2025-07-05',
                    'objective_list' => [
                        'Functional and safety concept development',
                        'FMEA, FMEDA, and Fault Tree Analysis',
                        'Tool qualification and safety case creation',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'ASPICE (Automotive SPICE)',
                    'description' => 'Achieve CL2/CL3 process maturity with a complete ASPICE lifecycle overview aligned to the V-model and quality assurance expectations.',
                    'category' => 'Automotive',
                    'date' => '2025-07-09',
                    'objective_list' => [
                        'Base and extended process understanding',
                        'Assessment preparation and process tailoring',
                        'Real-world mapping with cybersecurity and FuSa',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'AUTOSAR (Classic & Adaptive)',
                    'description' => 'Practical exposure to AUTOSAR software stack design, ECU configuration, and integration workflows powering modern SDVs.',
                    'category' => 'Automotive',
                    'date' => '2025-07-13',
                    'objective_list' => [
                        'AUTOSAR layered architecture and services',
                        'Classic and Adaptive platform differences',
                        'MCAL, BSW, RTE, and application layer interaction',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'OT Security (IEC 62443)',
                    'description' => 'Secure vehicle manufacturing lines, industrial setups, and in-vehicle OT layers with ICS/SCADA-focused strategies.',
                    'category' => 'Automotive',
                    'date' => '2025-07-17',
                    'objective_list' => [
                        'Network segmentation and asset classification',
                        'Risk assessments and security level determination',
                        'IEC 62443 alignment with automotive use cases',
                    ],
                    'status' => 'active',
                ],
                [
                    'title' => 'Software Update Management - ISO 24089',
                    'description' => 'Implement safe, compliant OTA update strategies through process development and practical deployment planning.',
                    'category' => 'Automotive',
                    'date' => '2025-07-21',
                    'objective_list' => [
                        'SUMS-compliant process creation and simulation',
                        'Risk assessment and rollback handling',
                        'Secure OTA update planning, testing, and documentation',
                    ],
                    'status' => 'active',
                ],
            ],
        ];

        // Load all categories into a map for faster lookup
        $categoriesMap = Category::pluck('id', 'title')->toArray();
        $missingCategories = [];
        
        // Verify all categories exist before processing
        $this->command->info('Verifying categories...');
        $defaultCurrencyCode = Currency::defaultCurrency()->code ?? 'INR';

        foreach ($contentData as $type => $items) {
            foreach ($items as $item) {
                if (!empty($item['category']) && !isset($categoriesMap[$item['category']])) {
                    if (!in_array($item['category'], $missingCategories)) {
                        $missingCategories[] = $item['category'];
                    }
                }
            }
        }
        
        if (!empty($missingCategories)) {
            $this->command->error('Missing categories in CategorySeeder: ' . implode(', ', $missingCategories));
            $this->command->error('Please add these categories to CategorySeeder before continuing.');
            return;
        }
        
        $this->command->info('All categories verified. Proceeding with content item creation...');
        $createdContentItemIds = [];

        foreach ($contentData as $type => $items) {
            foreach ($items as $index => $item) {
                // Find category by title if provided
                $categoryId = null;
                if (!empty($item['category'])) {
                    if (isset($categoriesMap[$item['category']])) {
                        $categoryId = $categoriesMap[$item['category']];
                    } else {
                        // This should not happen if verification passed, but handle it anyway
                        $this->command->warn("Category '{$item['category']}' not found for item: {$item['title']}");
                    }
                }
                
                // Check if item already exists (by type and title) to prevent duplicates
                $existingItem = ContentItem::where('type', $type)
                    ->where('title', $item['title'])
                    ->first();
                
                if ($existingItem) {
                    $this->command->info("Skipping duplicate: {$item['title']} (already exists)");
                    continue;
                }
                
                // Generate unique slug
                $baseSlug = \Illuminate\Support\Str::slug($item['title']);
                if ($type === 'blog' && !empty($item['date'])) {
                    $baseSlug = Carbon::parse($item['date'])->format('Y-m-d') . '-' . $baseSlug;
                }
                $slug = $baseSlug;
                $counter = 1;
                while (ContentItem::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                
                // Prepare base data
                $itemData = [
                    'type' => $type,
                    'title' => $item['title'],
                    'slug' => $slug,
                    'description' => $item['description'],
                    'category_id' => $categoryId,
                    'date' => Carbon::parse($item['date']),
                    'objective_list' => $item['objective_list'],
                    'status' => $item['status'],
                    'order' => $index,
                    'created_at' => Carbon::parse($item['date']),
                    'updated_at' => Carbon::parse($item['date']),
                ];

                $contentItem = ContentItem::create($itemData);
                $createdContentItemIds[] = $contentItem->id;
            }
        }

        $totalItems = array_sum(array_map('count', $contentData));
        $this->command->info('Content items seeded successfully!');
        $this->command->info("Total items created: {$totalItems}");
        
        if (!empty($missingCategories)) {
            $this->command->warn('Missing categories that need to be added: ' . implode(', ', $missingCategories));
        }
        
        // Report category assignment statistics
        $itemsWithCategories = ContentItem::whereNotNull('category_id')->count();
        $this->command->info("Items with categories assigned: {$itemsWithCategories} / {$totalItems}");

        $this->maybeAutoTranslateSeededContent($createdContentItemIds);
    }

    protected function maybeAutoTranslateSeededContent(array $contentItemIds): void
    {
        if (empty($contentItemIds) || !config('translation.auto_translate', false)) {
            return;
        }

        $targetLocales = array_filter(config('translation.target_locales', []));
        if (empty($targetLocales)) {
            return;
        }

        /** @var MachineTranslationService $machineTranslationService */
        $machineTranslationService = app(MachineTranslationService::class);
        if (!$machineTranslationService->isEnabled()) {
            $this->command->warn('Machine translation service not configured. Skipping auto translation for seeded content.');
            return;
        }

        $this->command->info('Auto-translating seeded content items...');

        foreach ($contentItemIds as $contentItemId) {
            AutoTranslateContentItem::dispatchSync($contentItemId, $targetLocales);
        }
    }
}
