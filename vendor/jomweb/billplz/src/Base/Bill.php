<?php

namespace Billplz\Base;

use Billplz\Request;
use InvalidArgumentException;
use Laravie\Codex\Contracts\Response;
use Billplz\Contracts\Bill as Contract;
use Laravie\Codex\Concerns\Request\Multipart;

abstract class Bill extends Request implements Contract
{
    use Multipart,
        PaymentCompletion;

    /**
     * Create a new bill.
     *
     * @param  \Money\Money|\Duit\MYR|int  $amount
     * @param  array|string  $callbackUrl
     *
     * @throws \InvalidArgumentException
     *
     * @return \Billplz\Response
     */
    public function create(
        string $collectionId,
        ?string $email,
        ?string $mobile,
        string $name,
        $amount,
        $callbackUrl,
        string $description,
        array $optional = []
    ): Response {
        if (empty($email) && empty($mobile)) {
            throw new InvalidArgumentException('Either $email or $mobile should be present');
        }

        $body = \array_merge(
            \compact('email', 'mobile', 'name', 'amount', 'description'), $optional
        );

        $body['collection_id'] = $collectionId;

        $body = $this->parseRedirectAndCallbackUrlFromRequest($body, $callbackUrl);

        return $this->stream('POST', 'bills', [], $body);
    }

    /**
     * Show an existing bill.
     *
     * @return \Billplz\Response
     */
    public function get(string $id): Response
    {
        return $this->send('GET', "bills/{$id}");
    }

    /**
     * Show an existing bill transactions.
     *
     * @return \Billplz\Response
     */
    public function transaction(string $id, array $optional = []): Response
    {
        return $this->client->uses(
            'Bill.Transaction', $this->getVersion()
        )->get($id, $optional);
    }

    /**
     * Destroy an existing bill.
     *
     * @return \Billplz\Response
     */
    public function destroy(string $id): Response
    {
        return $this->send('DELETE', "bills/{$id}");
    }
}
