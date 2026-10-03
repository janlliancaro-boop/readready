CREATE DATABASE IF NOT EXISTS `readready_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `readready_db`;

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(80) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(150) DEFAULT 'Administrator',
    role VARCHAR(50) NOT NULL DEFAULT 'super_admin',
    status VARCHAR(20) NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_admins_username (username)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS avatars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    avatar_name VARCHAR(50) NOT NULL,
    emoji VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_avatars_name (avatar_name)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS learners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    learner_token VARCHAR(64) NOT NULL UNIQUE,
    nickname VARCHAR(80) NOT NULL,
    avatar VARCHAR(20) NOT NULL DEFAULT '🙂',
    current_level VARCHAR(30) NOT NULL DEFAULT 'Beginner',
    stars INT NOT NULL DEFAULT 0,
    coins INT NOT NULL DEFAULT 0,
    total_badges INT NOT NULL DEFAULT 0,
    total_achievements INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_learners_nickname (nickname),
    INDEX idx_learners_token (learner_token),
    INDEX idx_learners_level (current_level)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS learner_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    learner_id INT NOT NULL,
    session_token VARCHAR(64) NOT NULL,
    user_agent VARCHAR(255) DEFAULT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    expires_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_learner_sessions_learner FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
    INDEX idx_learner_sessions_learner (learner_id),
    INDEX idx_learner_sessions_token (session_token)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS learner_progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    learner_id INT NOT NULL,
    lessons_completed INT NOT NULL DEFAULT 0,
    activities_completed INT NOT NULL DEFAULT 0,
    words_learned INT NOT NULL DEFAULT 0,
    progress_percent INT NOT NULL DEFAULT 0,
    quiz_score_total INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_learner_progress_learner FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
    INDEX idx_learner_progress_learner (learner_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS learner_badges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    learner_id INT NOT NULL,
    badge_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_learner_badges_learner FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
    INDEX idx_learner_badges_learner (learner_id),
    INDEX idx_learner_badges_badge (badge_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS learner_rewards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    learner_id INT NOT NULL,
    reward_id INT NOT NULL,
    stars_awarded INT NOT NULL DEFAULT 0,
    coins_awarded INT NOT NULL DEFAULT 0,
    trophy_awarded INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_learner_rewards_learner FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
    INDEX idx_learner_rewards_learner (learner_id),
    INDEX idx_learner_rewards_reward (reward_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS learner_activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    learner_id INT NOT NULL,
    activity_name VARCHAR(120) NOT NULL,
    activity_type VARCHAR(80) NOT NULL,
    session_data TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_learner_activities_learner FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
    INDEX idx_learner_activities_learner (learner_id),
    INDEX idx_learner_activities_name (activity_name)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS dictionary_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    icon VARCHAR(20) DEFAULT '📘',
    display_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_dictionary_category_name (name),
    INDEX idx_dictionary_category_order (display_order)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS dictionary_words (
    id INT AUTO_INCREMENT PRIMARY KEY,
    word VARCHAR(100) NOT NULL,
    definition TEXT NOT NULL,
    example_sentence TEXT,
    image_url VARCHAR(255) DEFAULT NULL,
    audio_url VARCHAR(255) DEFAULT NULL,
    category_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_dictionary_words_category FOREIGN KEY (category_id) REFERENCES dictionary_categories(id) ON DELETE CASCADE,
    INDEX idx_dictionary_words_word (word),
    INDEX idx_dictionary_words_category (category_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS lessons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    lesson_type VARCHAR(50) NOT NULL,
    description TEXT,
    difficulty VARCHAR(20) NOT NULL DEFAULT 'Beginner',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_lessons_type (lesson_type),
    INDEX idx_lessons_difficulty (difficulty)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS lesson_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lesson_id INT NOT NULL,
    category_name VARCHAR(120) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_lesson_categories_lesson FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE,
    INDEX idx_lesson_categories_lesson (lesson_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS quizzes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    category VARCHAR(80) NOT NULL,
    difficulty VARCHAR(20) NOT NULL DEFAULT 'Beginner',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_quizzes_category (category),
    INDEX idx_quizzes_difficulty (difficulty)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS quiz_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    question_text TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    correct_answer VARCHAR(255) NOT NULL,
    question_type VARCHAR(30) NOT NULL DEFAULT 'multiple_choice',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_quiz_questions_quiz FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE,
    INDEX idx_quiz_questions_quiz (quiz_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS quiz_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    learner_id INT NOT NULL,
    quiz_id INT NOT NULL,
    score INT NOT NULL,
    total_questions INT NOT NULL,
    percentage DECIMAL(5,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_quiz_results_learner FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
    CONSTRAINT fk_quiz_results_quiz FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE,
    INDEX idx_quiz_results_learner (learner_id),
    INDEX idx_quiz_results_quiz (quiz_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS spelling_words (
    id INT AUTO_INCREMENT PRIMARY KEY,
    word VARCHAR(120) NOT NULL,
    hint TEXT,
    difficulty VARCHAR(20) DEFAULT 'Beginner',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_spelling_word (word),
    INDEX idx_spelling_word_difficulty (difficulty)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS word_puzzles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    scrambled_word VARCHAR(120) NOT NULL,
    answer_word VARCHAR(120) NOT NULL,
    clue TEXT,
    difficulty VARCHAR(20) DEFAULT 'Beginner',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_word_puzzles_difficulty (difficulty)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS badges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    icon VARCHAR(50) DEFAULT '🏅',
    requirement VARCHAR(255) DEFAULT 'Complete the required learning task.',
    stars_reward INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_badge_name (name)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS rewards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    icon VARCHAR(50) DEFAULT '🎁',
    stars_award INT NOT NULL DEFAULT 0,
    coins_award INT NOT NULL DEFAULT 0,
    trophy_award INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_reward_name (name)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    learner_id INT DEFAULT NULL,
    activity_name VARCHAR(120) NOT NULL,
    activity_type VARCHAR(80) NOT NULL,
    session_data TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_activity_logs_learner FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE SET NULL,
    INDEX idx_activity_logs_learner (learner_id),
    INDEX idx_activity_logs_activity (activity_name)
) ENGINE=InnoDB;
