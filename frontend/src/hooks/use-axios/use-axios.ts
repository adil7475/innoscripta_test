import axios, {
    AxiosError,
    AxiosRequestConfig,
    AxiosResponse,
    Method
} from 'axios';
import {getToken} from "../../services/authentication/authentication";

export const useAxios = () => {
    const baseUrl = process.env.REACT_API_URL ?? 'http://127.0.0.1:8000/api'
    const request = (method: Method) => {
        return async <
            T = unknown,
            S = unknown,
            R extends Record<
                string,
                string | number | boolean | undefined
            > = Record<string, string | number | boolean | undefined>
        >(
            url: string,
            body?: S,
            config?: AxiosRequestConfig,
            options?: { showErrorToast?: boolean; filter?: R }
        ): Promise<T> => {
            const requestConfig: AxiosRequestConfig = {
                ...config,
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${getToken()}`
                },
                baseURL: baseUrl,
                method
            };
            if (body) {
                requestConfig.data = body;
            }

            // const requestUrl = `${url}${
            //     options?.filter ? `?${serializeQuery(options.filter)}` : ''
            // }`;
            const requestUrl = `${url}`

            try {
                const response = await axios(requestUrl, requestConfig);
                return handleResponse<T>(response);
            } catch (e) {
                return handleResponse(e as AxiosError);
            }
        };
    };
    const handleResponse = <T = unknown>(
        response: AxiosResponse | AxiosError
    ) => {
        if ('data' in response) {
            return response.data as T;
        } else {
            // const error =
            //     (response.response?.data as string | { message: string }) ??
            //     'Something went wrong.';
            // const errorMessage =
            //     typeof error === 'object' ? error?.message : error;
            return Promise.reject(response.response);
        }
    };

    return {
        get: request('GET'),
        post: request('POST'),
        put: request('PUT'),
        patch: request('PATCH'),
        del: request('DELETE')
    };
};