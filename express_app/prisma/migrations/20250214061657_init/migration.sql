-- CreateTable
CREATE TABLE `User` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(191) NOT NULL,
    `email` VARCHAR(191) NOT NULL,
    `name` VARCHAR(191) NULL,
    `mobile_no` VARCHAR(191) NULL,
    `token_key` VARCHAR(191) NULL,
    `auth_key` VARCHAR(191) NULL,

    UNIQUE INDEX `User_email_key`(`email`),
    PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `ShareSafari` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `share_safari_title` VARCHAR(191) NOT NULL,
    `type` INTEGER NOT NULL DEFAULT 1,
    `slug` VARCHAR(191) NOT NULL,
    `host_user_id` INTEGER NOT NULL,
    `host_type` INTEGER NOT NULL,
    `userId` INTEGER NULL,

    UNIQUE INDEX `ShareSafari_slug_key`(`slug`),
    PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- AddForeignKey
ALTER TABLE `ShareSafari` ADD CONSTRAINT `ShareSafari_userId_fkey` FOREIGN KEY (`userId`) REFERENCES `User`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;
