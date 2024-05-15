<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Activity
 *
 * @property int $id
 * @property int $school_id
 * @property int|null $teacher_id
 * @property string $name
 * @property string|null $bg_image
 * @property string $class
 * @property \Illuminate\Support\Carbon $activity_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\School $school
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @property-read \App\Models\Teacher|null $teacher
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereActivityDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereBgImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereUpdatedAt($value)
 */
	class Activity extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ActivityStudent
 *
 * @property-read \App\Models\Activity|null $activity
 * @property-read \App\Models\Student|null $student
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityStudent query()
 */
	class ActivityStudent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property-read string|null $avatar
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Article> $articles
 * @property-read int|null $articles_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Shetabit\Visitor\Models\Visit> $visits
 * @property-read int|null $visits_count
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin online(int $seconds = 180)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUsername($value)
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Article
 *
 * @property int $id
 * @property int $radio_id
 * @property string $author_type
 * @property int $author_id
 * @property string $title
 * @property string|null $attachment
 * @property int $is_public
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $author
 * @property-read \App\Models\Radio $radio
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereAuthorType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereRadioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedAt($value)
 */
	class Article extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FrontendContent
 *
 * @property int $id
 * @property string $section
 * @property object $content
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FrontendContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontendContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontendContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontendContent whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontendContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontendContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontendContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontendContent whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontendContent whereUpdatedAt($value)
 */
	class FrontendContent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Image
 *
 * @property int $id
 * @property string $imageable_type
 * @property int $imageable_id
 * @property string $path
 * @property int $order
 * @property int|null $file_size
 * @property string|null $file_type
 * @property string|null $thumbnail_path
 * @property string|null $external_url
 * @property string|null $type
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $imageable
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereExternalUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereImageableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereImageableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereThumbnailPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Image withoutTrashed()
 */
	class Image extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Radio
 *
 * @property int $id
 * @property int $semester_id
 * @property string $level
 * @property string|null $subject
 * @property string|null $attachment
 * @property int $week_number
 * @property \Illuminate\Support\Carbon $radio_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Article> $articles
 * @property-read int|null $articles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\School> $schools
 * @property-read int|null $schools_count
 * @property-read \App\Models\Semester $semester
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Teacher> $teachers
 * @property-read int|null $teachers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Shetabit\Visitor\Models\Visit> $visitLogs
 * @property-read int|null $visit_logs_count
 * @method static \Illuminate\Database\Eloquent\Builder|Radio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Radio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Radio query()
 * @method static \Illuminate\Database\Eloquent\Builder|Radio weekly()
 * @method static \Illuminate\Database\Eloquent\Builder|Radio whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Radio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Radio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Radio whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Radio whereRadioDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Radio whereSemesterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Radio whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Radio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Radio whereWeekNumber($value)
 */
	class Radio extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RadioStudent
 *
 * @property int $radio_id
 * @property int $student_id
 * @property int|null $article_id
 * @property int|null $rating
 * @property-read \App\Models\Article|null $article
 * @property-read \App\Models\Radio $radio
 * @property-read \App\Models\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder|RadioStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RadioStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RadioStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder|RadioStudent whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RadioStudent whereRadioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RadioStudent whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RadioStudent whereStudentId($value)
 */
	class RadioStudent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RadioTeacher
 *
 * @property int $radio_id
 * @property int $teacher_id
 * @property int|null $rating
 * @property-read \App\Models\Radio $radio
 * @property-read \App\Models\Teacher $teacher
 * @method static \Illuminate\Database\Eloquent\Builder|RadioTeacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RadioTeacher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RadioTeacher query()
 * @method static \Illuminate\Database\Eloquent\Builder|RadioTeacher whereRadioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RadioTeacher whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RadioTeacher whereTeacherId($value)
 */
	class RadioTeacher extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\School
 *
 * @property int $id
 * @property string $name
 * @property string $level
 * @property string $mod_name
 * @property string $email
 * @property string $country
 * @property string|null $city
 * @property string $accreditation_number
 * @property string|null $id_number
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property-read string|null $avatar
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Article> $articles
 * @property-read int|null $articles_count
 * @property-read \self $school
 * @property-read int $school_id
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Radio> $radios
 * @property-read int|null $radios_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @property-read \App\Models\Subscription\PlanSubscription|null $subscription
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subscription\SubscriptionPayment> $subscription_payments
 * @property-read int|null $subscription_payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Teacher> $teachers
 * @property-read int|null $teachers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Shetabit\Visitor\Models\Visit> $visits
 * @property-read int|null $visits_count
 * @method static \Illuminate\Database\Eloquent\Builder|School newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|School newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|School online(int $seconds = 180)
 * @method static \Illuminate\Database\Eloquent\Builder|School onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|School query()
 * @method static \Illuminate\Database\Eloquent\Builder|School whereAccreditationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereModName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|School withoutTrashed()
 */
	class School extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Semester
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Radio> $radios
 * @property-read int|null $radios_count
 * @method static \Illuminate\Database\Eloquent\Builder|Semester newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Semester newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Semester query()
 * @method static \Illuminate\Database\Eloquent\Builder|Semester whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Semester whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Semester whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Semester whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Semester whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Semester whereUpdatedAt($value)
 */
	class Semester extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Student
 *
 * @property int $id
 * @property int|null $school_id
 * @property string $name
 * @property string $email
 * @property string|null $phone_number
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $phone_verification_code
 * @property string|null $role
 * @property-read string|null $avatar
 * @property \Illuminate\Support\Carbon|null $last_phone_code_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\StudentProfile|null $profile
 * @property-read \App\Models\School|null $school
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Shetabit\Visitor\Models\Visit> $visits
 * @property-read int|null $visits_count
 * @method static \Database\Factories\StudentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User online(int $seconds = 180)
 * @method static \Illuminate\Database\Eloquent\Builder|Student onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder|User search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereLastPhoneCodeAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePhoneVerificationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Student withoutTrashed()
 */
	class Student extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StudentProfile
 *
 * @property int $id
 * @property int $student_id
 * @property string|null $parent_name
 * @property string|null $parent_email
 * @property string $level
 * @property string|null $class
 * @property string|null $division
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $student
 * @method static \Database\Factories\StudentProfileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProfile whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProfile whereDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProfile whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProfile whereParentEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProfile whereParentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProfile whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProfile whereUpdatedAt($value)
 */
	class StudentProfile extends \Eloquent {}
}

namespace App\Models\Subscription{
/**
 * App\Models\Subscription\Plan
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property string|null $short_description
 * @property object|null $features
 * @property string $price
 * @property string $currency
 * @property string $billing_interval
 * @property int $billing_period
 * @property int $sort_order
 * @property int $is_active
 * @property int $is_featured
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subscription\PlanSubscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Plan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereBillingInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereBillingPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan withoutTrashed()
 */
	class Plan extends \Eloquent {}
}

namespace App\Models\Subscription{
/**
 * App\Models\Subscription\PlanSubscription
 *
 * @property int $id
 * @property string $subscriber_type
 * @property int $subscriber_id
 * @property int $plan_id
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $ends_at
 * @property \Illuminate\Support\Carbon|null $renewed_at
 * @property \Illuminate\Support\Carbon|null $canceled_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Subscription\Plan $plan
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $subscriber
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription active()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription whereCanceledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription whereRenewedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription whereSubscriberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription whereSubscriberType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription withoutTrashed()
 */
	class PlanSubscription extends \Eloquent {}
}

namespace App\Models\Subscription{
/**
 * App\Models\Subscription\SubscriptionPayment
 *
 * @property int $id
 * @property string|null $transaction_id
 * @property string|null $merchant_reference
 * @property string $payer_type
 * @property int $payer_id
 * @property int $plan_id
 * @property string $payment_method
 * @property string $amount
 * @property string $currency
 * @property string|null $customer_email
 * @property string $subscription_interval
 * @property int $subscription_period
 * @property \Illuminate\Support\Carbon|null $initiated_at
 * @property \Illuminate\Support\Carbon|null $failed_at
 * @property \Illuminate\Support\Carbon|null $refunded_at
 * @property \Illuminate\Support\Carbon|null $canceled_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $on_hold_at
 * @property string $status
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $payer
 * @property-read \App\Models\Subscription\Plan $plan
 * @property-read \App\Models\Image|null $receipt
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereCanceledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereCustomerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereFailedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereInitiatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereMerchantReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereOnHoldAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment wherePayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment wherePayerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereRefundedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereSubscriptionInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereSubscriptionPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionPayment withoutTrashed()
 */
	class SubscriptionPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Teacher
 *
 * @property int $id
 * @property int|null $school_id
 * @property string $name
 * @property string $email
 * @property string|null $phone_number
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $phone_verification_code
 * @property string|null $role
 * @property-read string|null $avatar
 * @property \Illuminate\Support\Carbon|null $last_phone_code_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\School|null $school
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Shetabit\Visitor\Models\Visit> $visits
 * @property-read int|null $visits_count
 * @method static \Database\Factories\TeacherFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User online(int $seconds = 180)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher query()
 * @method static \Illuminate\Database\Eloquent\Builder|User search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereLastPhoneCodeAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher wherePhoneVerificationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher withoutTrashed()
 */
	class Teacher extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property int|null $school_id
 * @property string $name
 * @property string $email
 * @property string|null $phone_number
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $phone_verification_code
 * @property string|null $role
 * @property-read string|null $avatar
 * @property \Illuminate\Support\Carbon|null $last_phone_code_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\School|null $school
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Shetabit\Visitor\Models\Visit> $visits
 * @property-read int|null $visits_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User online(int $seconds = 180)
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastPhoneCodeAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneVerificationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

