<?php
/**
 * TagStoreRequest.php
 * Copyright (c) 2019 james@firefly-iii.org
 *
 * This file is part of Firefly III (https://github.com/firefly-iii).
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace FireflyIII\Api\V1\Requests;

use FireflyIII\Models\Location;

/**
 * Class TagStoreRequest
 *
 * @codeCoverageIgnore
 *
 */
class TagStoreRequest extends Request
{

    /**
     * Authorize logged in users.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Only allow authenticated users
        return auth()->check();
    }

    /**
     * Get all data from the request.
     *
     * @return array
     */
    public function getAll(): array
    {
        $hasLocation = false;
        if ($this->has('longitude') && $this->has('latitude') && $this->has('zoom_level')) {
            $hasLocation = true;
        }

        return [
            'tag'          => $this->string('tag'),
            'date'         => $this->date('date'),
            'description'  => $this->string('description'),
            'has_location' => $hasLocation,
            'longitude'    => $this->string('longitude'),
            'latitude'     => $this->string('latitude'),
            'zoom_level'   => $this->integer('zoom_level'),
        ];
    }

    /**
     * The rules that the incoming request must be matched against.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'tag'         => 'required|min:1|uniqueObjectForUser:tags,tag',
            'description' => 'min:1|nullable',
            'date'        => 'date|nullable',
        ];

        return Location::requestRules($rules);
    }
}
