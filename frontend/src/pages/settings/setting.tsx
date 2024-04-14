import React, {useEffect, useState} from "react";
import {Col, Form, Label, Input, Button} from "reactstrap";
import { AsyncPaginate } from "react-select-async-paginate";
import { usePreferences } from "../../services/preferences/preferences";
import { useRecoilValue } from "recoil";
import {Categories, Authors, Sources} from "../../store/preferences/preferences";
import {loader} from "../../store/loader/loader";

export const Setting = () => {
    const userCategories = useRecoilValue(Categories)
    const userSource = useRecoilValue(Sources)
    const userAuthors = useRecoilValue(Authors)
    const loading: boolean = useRecoilValue(loader)
    const [category, setCategory] = useState(userCategories)
    const [source, setSource] = useState(userSource)
    const [author, setAuthor] = useState(userAuthors)


    const {getCategories, getSources, getAuthors, updateSetting} = usePreferences()
    const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        await updateSetting(category, source, author)
    }
    return (
        <div className="cstm-container active-cont">
            <nav className="navbar top-navbar mobile-menu fixed-top bg-white">
                <a className="btn border-0" id="menu-btn">≡</a>
            </nav>
            <div className="settings-area mx-auto">
                <Form className="row g-3" onSubmit={(e) => handleSubmit(e)}>
                    <Col md={12}>
                        <Label className="mb-2 fw-bold">Select Categories</Label>
                        <AsyncPaginate
                            id="categories"
                            loadOptions={getCategories}
                            onChange={(e) => setCategory(e)}
                            debounceTimeout={1000}
                            additional={{page: 1}}
                            isMulti
                            value={category}
                            placeholder="Categories"
                        />
                    </Col>
                    <Col md={12}>
                        <Label className="mb-2 fw-bold">Select Sources</Label>
                        <AsyncPaginate
                            id="source"
                            loadOptions={getSources}
                            onChange={(e) => setSource(e)}
                            debounceTimeout={1000}
                            additional={{page: 1}}
                            isMulti
                            value={source}
                            placeholder="Sources"
                        />
                    </Col>
                    <Col md={12}>
                        <Label className="mb-2 fw-bold">Select Authors</Label>
                        <AsyncPaginate
                            id="authors"
                            loadOptions={getAuthors}
                            onChange={(e) => setAuthor(e)}
                            debounceTimeout={1000}
                            additional={{page: 1}}
                            isMulti
                            value={author}
                            placeholder="Sources"
                        />
                    </Col>
                    <Col md={12}>
                        <Button type='submit' color='primary' className="cstm-btn py-2 w-100" disabled={loading}>Save</Button>
                    </Col>
                </Form>
            </div>
        </div>
    )
}