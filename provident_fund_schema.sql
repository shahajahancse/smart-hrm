

CREATE TABLE `hrsale_provident_fund_accounts` (
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `opening_balance` decimal(15,2) NOT NULL DEFAULT '0.00',
  `current_balance` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_employee_contribution` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_employer_contribution` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_interest_earned` decimal(15,2) NOT NULL DEFAULT '0.00',
  `is_eligible_withdrawal` tinyint(1) NOT NULL DEFAULT '0',
  `is_eligible_loan` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hrsale_provident_fund_audit_trail`
--

CREATE TABLE `hrsale_provident_fund_audit_trail` (
  `audit_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Employee who performed the action or whose account was affected',
  `action_type` varchar(100) NOT NULL COMMENT 'e.g., "PF_SETTING_UPDATE", "CONTRIBUTION_ADD", "WITHDRAWAL_APPROVED"',
  `entity_type` varchar(100) NOT NULL COMMENT 'e.g., "pf_settings", "pf_contributions", "pf_withdrawals"',
  `entity_id` int(11) NOT NULL COMMENT 'ID of the affected record in its respective table',
  `old_value` text,
  `new_value` text,
  `changed_by` int(11) NOT NULL COMMENT 'User ID of the user who made the change',
  `changed_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hrsale_provident_fund_contributions`
--

CREATE TABLE `hrsale_provident_fund_contributions` (
  `contribution_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contribution_month` date NOT NULL COMMENT 'YYYY-MM-DD, day can be 01',
  `employee_contribution` decimal(15,2) NOT NULL,
  `employer_contribution` decimal(15,2) NOT NULL,
  `total_contribution` decimal(15,2) NOT NULL,
  `payroll_id` int(11) DEFAULT NULL COMMENT 'Link to payroll record if applicable',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hrsale_provident_fund_interest`
--

CREATE TABLE `hrsale_provident_fund_interest` (
  `interest_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `interest_year` int(4) NOT NULL,
  `interest_amount` decimal(15,2) NOT NULL,
  `balance_before_interest` decimal(15,2) NOT NULL,
  `balance_after_interest` decimal(15,2) NOT NULL,
  `calculated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hrsale_provident_fund_loans`
--

CREATE TABLE `hrsale_provident_fund_loans` (
  `loan_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `loan_amount` decimal(15,2) NOT NULL,
  `approved_amount` decimal(15,2) DEFAULT NULL,
  `interest_rate` decimal(5,2) NOT NULL COMMENT 'Loan specific interest rate',
  `repayment_period_months` int(11) NOT NULL,
  `monthly_installment` decimal(15,2) NOT NULL,
  `total_repaid_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `outstanding_balance` decimal(15,2) NOT NULL,
  `status` enum('pending','approved','rejected','active','completed') NOT NULL DEFAULT 'pending',
  `approval_level` int(11) NOT NULL DEFAULT '0' COMMENT '0: Pending TL, 1: TL Approved, 2: HR Approved, etc.',
  `approved_by_tl` int(11) DEFAULT NULL,
  `approved_by_hr` int(11) DEFAULT NULL,
  `approved_by_manager` int(11) DEFAULT NULL,
  `approved_by_director` int(11) DEFAULT NULL,
  `approved_by_md` int(11) DEFAULT NULL,
  `disbursed_date` datetime DEFAULT NULL,
  `remarks` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hrsale_provident_fund_loan_repayments`
--

CREATE TABLE `hrsale_provident_fund_loan_repayments` (
  `repayment_id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `repayment_date` date NOT NULL,
  `amount_paid` decimal(15,2) NOT NULL,
  `principal_paid` decimal(15,2) NOT NULL,
  `interest_paid` decimal(15,2) NOT NULL,
  `payroll_id` int(11) DEFAULT NULL COMMENT 'Link to payroll record if applicable',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hrsale_provident_fund_settings`
--

CREATE TABLE `hrsale_provident_fund_settings` (
  `setting_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_contribution_rate` decimal(5,2) NOT NULL COMMENT 'Percentage of basic salary',
  `employer_contribution_rate` decimal(5,2) NOT NULL COMMENT 'Percentage of basic salary',
  `bank_interest_rate` decimal(5,2) NOT NULL COMMENT 'Annual bank interest rate',
  `min_service_period_withdrawal` int(11) NOT NULL COMMENT 'Minimum service period in years for withdrawal eligibility',
  `min_service_period_loan` int(11) NOT NULL COMMENT 'Minimum service period in years for loan eligibility',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hrsale_provident_fund_withdrawals`
--

CREATE TABLE `hrsale_provident_fund_withdrawals` (
  `withdrawal_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `withdrawal_type` enum('partial','full') NOT NULL,
  `purpose` text,
  `requested_amount` decimal(15,2) NOT NULL,
  `approved_amount` decimal(15,2) DEFAULT NULL,
  `status` enum('pending','approved','rejected','disbursed') NOT NULL DEFAULT 'pending',
  `approval_level` int(11) NOT NULL DEFAULT '0' COMMENT '0: Pending TL, 1: TL Approved, 2: HR Approved, etc.',
  `approved_by_tl` int(11) DEFAULT NULL COMMENT 'User ID of Team Lead who approved',
  `approved_by_hr` int(11) DEFAULT NULL COMMENT 'User ID of HR who approved',
  `approved_by_manager` int(11) DEFAULT NULL,
  `approved_by_director` int(11) DEFAULT NULL,
  `approved_by_md` int(11) DEFAULT NULL,
  `disbursed_date` datetime DEFAULT NULL,
  `remarks` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hrsale_provident_fund_accounts`
--
ALTER TABLE `hrsale_provident_fund_accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `account_number` (`account_number`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `hrsale_provident_fund_audit_trail`
--
ALTER TABLE `hrsale_provident_fund_audit_trail`
  ADD PRIMARY KEY (`audit_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `changed_by` (`changed_by`);

--
-- Indexes for table `hrsale_provident_fund_contributions`
--
ALTER TABLE `hrsale_provident_fund_contributions`
  ADD PRIMARY KEY (`contribution_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `hrsale_provident_fund_interest`
--
ALTER TABLE `hrsale_provident_fund_interest`
  ADD PRIMARY KEY (`interest_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `hrsale_provident_fund_loans`
--
ALTER TABLE `hrsale_provident_fund_loans`
  ADD PRIMARY KEY (`loan_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `hrsale_provident_fund_loan_repayments`
--
ALTER TABLE `hrsale_provident_fund_loan_repayments`
  ADD PRIMARY KEY (`repayment_id`),
  ADD KEY `loan_id` (`loan_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `hrsale_provident_fund_settings`
--
ALTER TABLE `hrsale_provident_fund_settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `company_id` (`company_id`);

--
-- Indexes for table `hrsale_provident_fund_withdrawals`
--
ALTER TABLE `hrsale_provident_fund_withdrawals`
  ADD PRIMARY KEY (`withdrawal_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hrsale_provident_fund_accounts`
--
ALTER TABLE `hrsale_provident_fund_accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hrsale_provident_fund_audit_trail`
--
ALTER TABLE `hrsale_provident_fund_audit_trail`
  MODIFY `audit_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hrsale_provident_fund_contributions`
--
ALTER TABLE `hrsale_provident_fund_contributions`
  MODIFY `contribution_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `hrsale_provident_fund_interest`
--
ALTER TABLE `hrsale_provident_fund_interest`
  MODIFY `interest_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `hrsale_provident_fund_loans`
--
ALTER TABLE `hrsale_provident_fund_loans`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hrsale_provident_fund_loan_repayments`
--
ALTER TABLE `hrsale_provident_fund_loan_repayments`
  MODIFY `repayment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hrsale_provident_fund_settings`
--
ALTER TABLE `hrsale_provident_fund_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hrsale_provident_fund_withdrawals`
--
ALTER TABLE `hrsale_provident_fund_withdrawals`
  MODIFY `withdrawal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `hrsale_provident_fund_accounts`
--
ALTER TABLE `hrsale_provident_fund_accounts`
  ADD CONSTRAINT `hrsale_provident_fund_accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `xin_employees` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hrsale_provident_fund_audit_trail`
--
ALTER TABLE `hrsale_provident_fund_audit_trail`
  ADD CONSTRAINT `hrsale_provident_fund_audit_trail_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `xin_employees` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hrsale_provident_fund_audit_trail_ibfk_2` FOREIGN KEY (`changed_by`) REFERENCES `xin_employees` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hrsale_provident_fund_contributions`
--
ALTER TABLE `hrsale_provident_fund_contributions`
  ADD CONSTRAINT `hrsale_provident_fund_contributions_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `hrsale_provident_fund_accounts` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hrsale_provident_fund_contributions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `xin_employees` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hrsale_provident_fund_interest`
--
ALTER TABLE `hrsale_provident_fund_interest`
  ADD CONSTRAINT `hrsale_provident_fund_interest_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `hrsale_provident_fund_accounts` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hrsale_provident_fund_interest_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `xin_employees` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hrsale_provident_fund_loans`
--
ALTER TABLE `hrsale_provident_fund_loans`
  ADD CONSTRAINT `hrsale_provident_fund_loans_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `hrsale_provident_fund_accounts` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hrsale_provident_fund_loans_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `xin_employees` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hrsale_provident_fund_loan_repayments`
--
ALTER TABLE `hrsale_provident_fund_loan_repayments`
  ADD CONSTRAINT `hrsale_provident_fund_loan_repayments_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `hrsale_provident_fund_loans` (`loan_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hrsale_provident_fund_loan_repayments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `xin_employees` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hrsale_provident_fund_withdrawals`
--
ALTER TABLE `hrsale_provident_fund_withdrawals`
  ADD CONSTRAINT `hrsale_provident_fund_withdrawals_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `hrsale_provident_fund_accounts` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hrsale_provident_fund_withdrawals_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `xin_employees` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
