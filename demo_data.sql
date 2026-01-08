USE job_portal;
DELETE FROM applications;
DELETE FROM candidates;
DELETE FROM jobs;
INSERT INTO jobs (
        title,
        company,
        location,
        category,
        description,
        requirements,
        salary,
        job_type,
        created_at
    )
VALUES (
        'Senior PHP Developer',
        'Banglalink Digital',
        'Dhaka',
        'IT',
        'We are looking for an experienced PHP developer to join our team. You will be responsible for developing and maintaining web applications using PHP, MySQL, and modern frameworks.',
        'Bachelor degree in Computer Science\n5+ years of PHP development experience\nStrong knowledge of MySQL\nExperience with MVC architecture\nGood communication skills',
        '৳80,000 - ৳100,000',
        'Full-time',
        '2025-12-15 10:30:00'
    ),
    (
        'Junior Frontend Developer',
        'Brain Station 23',
        'Dhaka',
        'IT',
        'Join our creative team as a Junior Frontend Developer. You will work on exciting web projects using HTML, CSS, JavaScript, and modern frontend frameworks.',
        'Bachelor degree in related field\n1-2 years of frontend development experience\nProficiency in HTML, CSS, JavaScript\nKnowledge of React or Vue.js\nPortfolio of web projects',
        '৳50,000 - ৳65,000',
        'Full-time',
        '2025-12-18 14:20:00'
    ),
    (
        'Marketing Manager',
        'Grameenphone',
        'Dhaka',
        'Marketing',
        'We are seeking a Marketing Manager to lead our digital marketing campaigns. You will develop marketing strategies, manage social media, and analyze campaign performance.',
        'Bachelor degree in Marketing or related field\n3+ years of marketing experience\nExperience with digital marketing tools\nStrong analytical skills\nExcellent communication skills',
        '৳65,000 - ৳85,000',
        'Full-time',
        '2025-12-20 09:15:00'
    ),
    (
        'Sales Executive',
        'Brac Bank',
        'Chittagong',
        'Sales',
        'Looking for a dynamic Sales Executive to join our sales team. You will be responsible for generating leads, closing deals, and maintaining client relationships.',
        'Bachelor degree in Business or related field\n2+ years of sales experience\nProven track record of meeting sales targets\nExcellent negotiation skills\nStrong interpersonal skills',
        '৳55,000 - ৳70,000 + Commission',
        'Full-time',
        '2025-12-22 11:45:00'
    ),
    (
        'Financial Analyst',
        'IDLC Finance',
        'Dhaka',
        'Finance',
        'Join our finance team as a Financial Analyst. You will analyze financial data, prepare reports, and provide insights to support business decisions.',
        'Bachelor degree in Finance or Accounting\n2-4 years of financial analysis experience\nProficiency in Excel and financial software\nStrong analytical and problem-solving skills\nAttention to detail',
        '৳60,000 - ৳75,000',
        'Full-time',
        '2025-12-25 13:30:00'
    ),
    (
        'HR Specialist',
        'Robi Axiata',
        'Dhaka',
        'HR',
        'We are looking for an HR Specialist to manage recruitment, employee relations, and HR administration. You will play a key role in building our company culture.',
        'Bachelor degree in Human Resources or related field\n3+ years of HR experience\nKnowledge of employment laws\nExcellent interpersonal skills\nHRCI or SHRM certification preferred',
        '৳55,000 - ৳70,000',
        'Full-time',
        '2025-12-28 10:00:00'
    ),
    (
        'Full Stack Developer',
        'Pathao',
        'Dhaka',
        'IT',
        'We need a talented Full Stack Developer to work on cutting-edge web applications. You will work with both frontend and backend technologies.',
        'Bachelor degree in Computer Science\n4+ years of full stack development experience\nProficiency in JavaScript, Node.js, React\nExperience with databases (MySQL, MongoDB)\nAgile development experience',
        '৳90,000 - ৳120,000',
        'Full-time',
        '2025-12-30 15:20:00'
    ),
    (
        'Content Marketing Specialist',
        'Daraz Bangladesh',
        'Dhaka',
        'Marketing',
        'Join our team as a Content Marketing Specialist. You will create engaging content, manage blogs, and develop content strategies to drive traffic.',
        'Bachelor degree in Marketing, Journalism, or related field\n2+ years of content marketing experience\nExcellent writing and editing skills\nSEO knowledge\nExperience with CMS platforms',
        '৳50,000 - ৳65,000',
        'Full-time',
        '2026-01-02 09:30:00'
    ),
    (
        'Sales Manager',
        'ACI Limited',
        'Sylhet',
        'Sales',
        'We are hiring a Sales Manager to lead our sales team. You will develop sales strategies, mentor team members, and drive revenue growth.',
        'Bachelor degree in Business or related field\n5+ years of sales experience with 2+ years in management\nProven leadership skills\nStrong business acumen\nExcellent presentation skills',
        '৳75,000 - ৳95,000 + Bonus',
        'Full-time',
        '2026-01-03 11:00:00'
    ),
    (
        'Junior Accountant',
        'Square Pharmaceuticals',
        'Dhaka',
        'Finance',
        'Looking for a Junior Accountant to assist with bookkeeping, financial reporting, and tax preparation. Great opportunity for career growth.',
        'Bachelor degree in Accounting\n1-2 years of accounting experience\nKnowledge of accounting principles\nProficiency in QuickBooks or similar software\nDetail-oriented',
        '৳45,000 - ৳55,000',
        'Full-time',
        '2026-01-04 14:15:00'
    );
INSERT INTO candidates (
        name,
        email,
        phone,
        password,
        resume_path,
        created_at
    )
VALUES (
        'Tanvir Ahmed',
        'tanvir.ahmed@email.com',
        '01712345678',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'public/uploads/resumes/resume_1_demo.pdf',
        '2025-12-10 08:00:00'
    ),
    (
        'Nusrat Jahan',
        'nusrat.jahan@email.com',
        '01812345679',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'public/uploads/resumes/resume_2_demo.pdf',
        '2025-12-12 09:30:00'
    ),
    (
        'Rahim Khan',
        'rahim.khan@email.com',
        '01912345680',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'public/uploads/resumes/resume_3_demo.pdf',
        '2025-12-15 10:15:00'
    ),
    (
        'Fatima Akter',
        'fatima.akter@email.com',
        '01612345681',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'public/uploads/resumes/resume_4_demo.pdf',
        '2025-12-18 11:00:00'
    ),
    (
        'Kamal Hossain',
        'kamal.hossain@email.com',
        '01512345682',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'public/uploads/resumes/resume_5_demo.pdf',
        '2025-12-20 13:45:00'
    );
INSERT INTO applications (job_id, candidate_id, status, applied_at)
VALUES (1, 1, 'pending', '2025-12-16 09:00:00'),
    (2, 1, 'accepted', '2025-12-19 10:30:00'),
    (3, 2, 'pending', '2025-12-21 11:00:00'),
    (4, 2, 'rejected', '2025-12-23 14:15:00'),
    (5, 3, 'pending', '2025-12-26 09:30:00'),
    (6, 3, 'accepted', '2025-12-29 10:00:00'),
    (7, 4, 'pending', '2025-12-31 11:15:00'),
    (8, 4, 'pending', '2026-01-03 09:00:00'),
    (1, 5, 'pending', '2025-12-17 10:00:00'),
    (9, 5, 'accepted', '2026-01-04 11:30:00');
